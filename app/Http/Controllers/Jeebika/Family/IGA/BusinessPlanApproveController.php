<?php

namespace App\Http\Controllers\Jeebika\Family\IGA;

use App\Enums\IGA\JBusinessPlanInvestmentReturnType;
use App\Enums\IGA\JBusinessPlanMeetingStatus;
use App\Enums\IGA\JBusinessPlanStatus;
use App\Enums\IGA\JInvestmentReturnStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\File;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Settings\JInvestmentArea;
use App\Rules\Remarks;
use DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BusinessPlanApproveController extends Controller
{
    public function viewById($gid, $id)
    {
        $bp = JBusinessPlan::with([
            'resource',
            'resolution_processed_by:id,name',
            'j_gro:id,name',
            'family:id,name',
            'j_investment_area:id,name',
            'familyBalance',
            'sources',
            'fields',
            'risks'
        ])->findOrFail($id);
        if (JBusinessPlanStatus::Pending === $bp->status || JBusinessPlanStatus::Hold === $bp->status) {
            $bp['histories'] = JBusinessPlan::with('j_investment_approved_area:id,name')
                ->withCount(['total_returns as total_amount' => function ($query) {
                    $query->select(DB::raw('sum(approved_amount)'))->whereStatus(JInvestmentReturnStatus::Approved);
                }])
                ->where('meeting_status', JBusinessPlanMeetingStatus::Approved)
                ->where('family_id', $bp->family_id)->latest()->get();
            $bp['meetingStatuses'] = JBusinessPlanMeetingStatus::cases();
            $bp['investmentReturnTypes'] = JBusinessPlanInvestmentReturnType::cases();
            $bp['investmentAreas'] = JInvestmentArea::getAll();
            $bp['gro_heads'] = Jeebika::join(Family::getTableName() . ' as f', 'f.id', '=', 'family_id')
                ->join(Mustahiq::getTableName() . ' as m', 'm.id', '=', 'f.family_head_id')
                ->select('m.id as id', 'm.name as text')->where('j_gro_id', $bp->j_gro_id)->get();
        }
        return view('dashboard.jeebika.gro.business-plan.bp-approve-view', compact('bp'));
    }

    public function index($gid): Renderable
    {
        $gro = JGro::findOrFail($gid);
        return view('dashboard.jeebika.gro.business-plan.bp-approve-list', compact('gro'));
    }

    public function update(Request $request, $gid): JsonResponse
    {
        $rules = [
            'id'                                        => ['required', Rule::exists(JBusinessPlan::getTableName(), 'id')],
            'is_valid_information'                      => ['required', 'in:true,false'],
            'is_previous_installment'                   => ['required', 'in:true,false'],
            'is_proposed_business_skill_and_experience' => ['required', 'in:true,false'],
            'is_general_savings'                        => ['required', 'in:true,false'],
            'is_recommended'                            => ['required', 'in:true,false'],
            'recommendation_remarks'                    => ['nullable', new Remarks(), 'max:999'],
            'meeting_date'                              => ['required', 'date'],
            'meeting_status'                            => ['required', new Enum(JBusinessPlanMeetingStatus::class)],
            'gro_remarks'                               => ['nullable', new Remarks(), 'max:999'],
        ];
        if (JBusinessPlanMeetingStatus::Approved == $request->meeting_status) {
            $rules['approved_amount'] = ['required', 'numeric', 'digits_between:0,50'];
            $rules['disbursement_date'] = ['required', 'date', 'max:10'];
            $rules['disbursement_amount'] = ['required', 'numeric', 'digits_between:0,50'];
            $rules['approved_investment_area_id'] = ['required', 'numeric', Rule::exists(JInvestmentArea::getTableName(), 'id')];
            $rules['approved_investment_return_type'] = ['required', new Enum(JBusinessPlanInvestmentReturnType::class)];
            $rules['file'] = ['required', 'mimes:jpeg,jpg,png,pdf']; // 100kb
            $rules['file_remarks'] = ['required', new Remarks(), 'max:999'];
            $rules['resolution_processed_by'] = ['required', Rule::exists(Family::getTableName(), 'family_head_id')];
        }
        $request->validate($rules, [
            'file.required'         => 'The resolution is required.',
            'file.mimes'            => 'The resolution file type is invalid, only jpeg,jpg,png,pdf are accepted.',
            'file_remarks.required' => 'The resolution remarks is required.',
            'file_remarks.name'     => 'The resolution remarks only accept a to z, 0 to 9, ), @, (, dash, colon, coma, dot and space.',
            'file_remarks.max'      => 'The resolution remarks may not be greater than 999 characters.',
        ]);
        $bp = JBusinessPlan::findOrFail($request->id);
        if ($request->hasFile('file')) {
            $fileName = strtolower(File::getUniqueFileName() . '.' . $request->file('file')->getClientOriginalExtension());
            $request->file('file')->storeAs(JBusinessPlan::RESOURCE_PATH, $fileName, 'public');
            $bp->resource()->create([
                'path'    => JBusinessPlan::RESOURCE_PATH,
                'name'    => $fileName,
                'remarks' => $request->file_remarks ?? null
            ]);
        }
        $bp->is_valid_information = $request->is_valid_information == "true";
        $bp->is_previous_installment = $request->is_previous_installment == "true";
        $bp->is_proposed_business_skill_and_experience = $request->is_proposed_business_skill_and_experience == "true";
        $bp->is_general_savings = $request->is_general_savings == "true";
        $bp->is_recommended = $request->is_recommended == "true";
        $bp->recommendation_remarks = $request->recommendation_remarks ?: null;
        $bp->meeting_date = $request->meeting_date;
        $bp->meeting_status = $request->meeting_status;
        $bp->gro_remarks = $request->gro_remarks ?: null;
        // if meeting status hold
        if (JBusinessPlanMeetingStatus::Hold->value === $request->meeting_status) {
            $bp->status = JBusinessPlanStatus::Hold;
        }
        // if meeting rejected
        if (JBusinessPlanMeetingStatus::Rejected->value === $request->meeting_status) {
            $bp->status = JBusinessPlanStatus::Rejected;
        }
        // if meeting status approved
        if (JBusinessPlanMeetingStatus::Approved->value === $request->meeting_status) {
            $bp->status = JBusinessPlanStatus::Approved;
            $bp->disbursement_date = $request->disbursement_date;
            $bp->disbursement_amount = $request->disbursement_amount;
            $bp->approved_investment_area_id = $request->approved_investment_area_id;
            $bp->approved_investment_return_type = $request->approved_investment_return_type;
            $bp->approved_amount = $request->approved_amount;
            $bp->resolution_processed_by = $request->resolution_processed_by;
        }
        $bp->updated_by = $request->updated_by;
        $bp->updated_at = now();
        $bp->save();
        return response()->json(['success' => 'Business Plan has been successfully updated.'], Response::HTTP_OK);
    }

    public function getList(Request $request, $gid): JsonResponse
    {
        $request->validate([
            "page"   => 'nullable|numeric|digits_between:1,10',
            "sort"   => 'nullable|in:family_name,business_name,area_name,status,created_at',
            "type"   => 'nullable|in:asc,desc',
            "query"  => 'nullable|string|max:50',
            "item"   => 'nullable|in:25,50,100,200',
            "status" => 'nullable', new Enum(JBusinessPlanStatus::class)
        ]);
        $sort = $request->input("sort") ?? 'created_at';
        $type = $request->input("type") ?? "asc";
        $query = $request->input("query");
        $item = $request->input("item") ?? getItemPerPage();
        $status = $request->input("status") ?? "";

        $f = Family::getTableName();
        $b = JBusinessPlan::getTableName();
        $i = JInvestmentArea::getTableName();
        $data = JBusinessPlan::leftJoin($f . ' as f', 'f.id', '=', $b . '.family_id')
            ->leftJoin($i . ' as i', 'i.id', '=', $b . '.j_investment_area_id')
            ->select($b . '.id as id', $b . '.created_at as created_at', $b . '.status as status', 'f.id as family_id', 'f.name as family_name', 'i.name as area_name', 'j_gro_id', 'business_name', 'business_seed_money')
            ->where('j_gro_id', $gid)
            ->when($status, function ($sql) use ($b, $status) {
                $sql->where($b . '.status', $status);
            })
            ->when($query, function ($sql) use ($query) {
                $sql->where('business_name', 'LIKE', '%' . $query . '%')
                    ->orWhere('f.name', 'LIKE', '%' . $query . '%')
                    ->orWhere('i.name', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists'    => $data,
            'statuses' => JBusinessPlanStatus::cases()
        ], Response::HTTP_OK);
    }
}
