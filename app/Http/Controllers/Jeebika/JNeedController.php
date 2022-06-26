<?php

namespace App\Http\Controllers\Jeebika;

use App\Enums\FamilyStatus;
use App\Enums\IndicatorType;
use App\Enums\JImplementationPlanStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JNeed;
use App\Models\Jeebika\JNeedAnalysis;
use App\Models\Jeebika\Project\JImplementationPlan;
use App\Models\Jeebika\Settings\JIndicator;
use DB;
use Error;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class JNeedController extends Controller
{
    public function index($id): Renderable
    {
        $family = Family::with(['members', 'head'])->firstWhere('id', '=', $id);
        $family->programs = JIndicator::getAll(['id', 'name', 'type', 'program_type', 'status'], 'sequence')->groupBy('program_type')->map(function ($item) {
            return $item->groupBy('type');
        });
        return view('dashboard.jeebika.family.need', compact('family'));
    }

    public function create(Request $request, $fid): JsonResponse
    {
        $family = Family::whereStatus(FamilyStatus::Active)->findOrFail($fid);
        $jeebika = Jeebika::where('family_id', $family->id)->firstOrFail();;
        $indicators = JIndicator::getAll(['id', 'name']);
        $sourceNeeds = collect(json_decode($request->data));
        if ($family->need_assessment) {
            return response()->json(["message" => "Family need already been assessed. Please contact with administrator."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (JNeed::where('family_id', $family->id)->first()) {
            return response()->json(["message" => "Family need already exist. Please contact with administrator."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $rows = [];
        foreach ($sourceNeeds as $sourceNeed) {
            $indicator = $indicators->where('id', '=', $sourceNeed->j_indicator_id)->first();
            $data = [
                'j_project_id' => $jeebika->j_project_id,
                'j_gro_id' => $jeebika->j_gro_id,
                'family_id' => $family->id,
                'j_indicator_id' => $indicator->id,
                'is_need' => 1,
                'created_by' => $request->created_by,
                'created_at' => now(),
            ];
            if ($sourceNeed->type === 'Member') {
                $mustahiq = Mustahiq::find($sourceNeed->variable_id);
                $data['member_id'] = $mustahiq->id;
            }
            $rows[] = $data;
        }
        //family table need asses status update
        $family->need_assessment = true;
        $family->updated_by = \request('updated_by');
        try {
            DB::transaction(function () use ($rows, $family, $jeebika, $sourceNeeds) {
                foreach ($rows as $row) {
                    JNeed::create($row);
                }
                $family->save();
                foreach ($sourceNeeds->pluck('j_indicator_id') as $indicatorId) {
                    $exist = JNeedAnalysis::where('j_project_id', $jeebika->j_project_id)->where('j_gro_id', $jeebika->j_gro_id)->where('j_indicator_id', $indicatorId)->first();
                    if ($exist) {
                        $exist->total_need += 1;
                        $exist->save();
                    } else {
                        JNeedAnalysis::create([
                            'j_project_id' => $jeebika->j_project_id,
                            'j_gro_id' => $jeebika->j_gro_id,
                            'j_indicator_id' => $indicatorId,
                            'total_need' => 1,
                        ]);
                    }
                }
            });
        } catch (Exception $e) {
            return response()->json(["message" => "An exception occurred, please contact with administrator. " . $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Error $e) {
            return response()->json(["message" => "An error occurred, please contact with administrator. " . $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $family->name . " needs are successfully created."], Response::HTTP_OK);
    }

    public function createSingle(Request $request, $fid): JsonResponse
    {
        $request->validate([
            'indicator_id' => ['bail', 'required', Rule::exists(JIndicator::getTableName(), 'id')],
            'member_id' => ['nullable', Rule::requiredIf(fn() => JIndicator::find($request->indicator_id)->type === IndicatorType::Member->value), Rule::exists(Mustahiq::getTableName(), 'id')]
        ]);
        $jeebika = Jeebika::where('family_id', $fid)->firstOrFail();;
        $indicator = JIndicator::find($request->indicator_id);
        $member = isset($request->member_id) ? Mustahiq::find($request->member_id) : null;

        $jNeed = JNeed::where('family_id', $fid)->where('j_indicator_id', $request->indicator_id)->when($member, function ($builder) use ($request) {
            $builder->where('member_id', $request->member_id);
        })->first();
        if ($jNeed) {
            $message = $member ? "{$indicator->name} need already exists for {$member->name}, Please try a different need indicator." : "{$indicator->name} need already exists, Please try a different need indicator.";
            return response()->json(["message" => $message], Response::HTTP_OK);
        }
        DB::transaction(function () use ($jeebika, $request, $fid, $indicator) {
            $data = [
                'j_project_id' => $jeebika->j_project_id,
                'j_gro_id' => $jeebika->j_gro_id,
                'family_id' => $fid,
                'j_indicator_id' => $indicator->id,
                'is_need' => 1,
                'created_by' => $request->created_by,
                'created_at' => now(),
            ];
            if ($indicator->type === IndicatorType::Member->value) {
                $data['member_id'] = Mustahiq::find($request->member_id)->id;
            }
            JNeed::create($data);
            $existingNeedAnalysis = JNeedAnalysis::where('j_project_id', $jeebika->j_project_id)->where('j_gro_id', $jeebika->j_gro_id)->where('j_indicator_id', $indicator->id)->first();
            if ($existingNeedAnalysis) {
                $existingNeedAnalysis->total_need += 1;
                $existingNeedAnalysis->save();
            } else {
                JNeedAnalysis::create([
                    'j_project_id' => $jeebika->j_project_id,
                    'j_gro_id' => $jeebika->j_gro_id,
                    'j_indicator_id' => $indicator->id,
                    'total_need' => 1,
                ]);
            }
        });
        return response()->json(["success" => $indicator->name . " need has been successfully created."], Response::HTTP_OK);
    }

    public function getList(Request $request, $fid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'member_id,j_indicator_id,is_need');
        $family = Family::findOrFail($fid);
        $data = JNeed::with([
            'family:id,name',
            'member:id,name',
            'j_indicator:id,name'
        ])
            ->select('id', 'family_id', 'member_id', 'j_indicator_id', 'is_need')
            ->when($query, function ($builder) use ($query) {
                $builder->whereHas('family', function ($sql) use ($query) {
                    $sql->where('name', 'LIKE', '%' . $query . '%');
                })->orWhereHas('member', function ($sql2) use ($query) {
                    $sql2->where('name', 'LIKE', '%' . $query . '%');
                })->orWhereHas('j_indicator', function ($sql2) use ($query) {
                    $sql2->where('name', 'LIKE', '%' . $query . '%');
                });
            })
            ->where('family_id', $fid)
            ->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists' => $data,
            'familyMembers' => $family->members_info()->select(Mustahiq::getTableName() . '.id as id', 'name')->get(),
            'indicators' => JIndicator::getAll(['id', 'name', 'type'])
        ], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $jNeed = JNeed::findOrFail($id);
        $ipNotPending = JImplementationPlan::when($jNeed->j_indicator->type === IndicatorType::Member->value, function ($builder) use ($jNeed) {
            $builder->where('member_id', $jNeed->member_id);
        })->where('j_indicator_id', $jNeed->j_indicator_id)->where('family_id', $jNeed->family_id)->where('implement_status', '!=', JImplementationPlanStatus::Pending)->first();
        if ($ipNotPending) {
            return response()->json(["message" => "This need's implementation status is {$ipNotPending->implement_status->value}. Only pending need can be deleted."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        DB::transaction(function () use ($jNeed) {
            $jNeed->delete();
            $needAnalysis = JNeedAnalysis::where('j_project_id', $jNeed->j_project_id)->where('j_gro_id', $jNeed->j_gro_id)->where('j_indicator_id', $jNeed->j_indicator_id)->first();
            $needAnalysis->total_need -= 1;
            $needAnalysis->save();
            JImplementationPlan::when($jNeed->j_indicator->type === IndicatorType::Member->value, function ($builder) use ($jNeed) {
                $builder->where('member_id', $jNeed->member_id);
            })->where('j_indicator_id', $jNeed->j_indicator_id)->where('family_id', $jNeed->family_id)->where('implement_status', JImplementationPlanStatus::Pending)->delete();
        });
        return response()->json(["success" => $jNeed->j_indicator->name . " has been successfully deleted."], Response::HTTP_OK);
    }
}
