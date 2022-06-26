<?php

namespace App\Http\Controllers\Jeebika\FamilyValidation;

use App\Enums\FamilyStatus;
use App\Enums\JGroStatus;
use App\Enums\MustahiqStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyMember;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Mustahiq\MustahiqDetail;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use function view;

class FamilyValidationController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.jeebika.family-validation.family-validation');
    }

    public function create(Request $request): JsonResponse
    {
        if ('verify' == $request->flag) {
            $status = FamilyStatus::Verified;
        } elseif ('reject' == $request->flag) {
            $status = FamilyStatus::Rejected;
        } elseif ('approve' == $request->flag) {
            $status = FamilyStatus::Active;
        } else {
            $status = FamilyStatus::Pending;
        }

        DB::transaction(function () use ($request, $status) {
            foreach ($request->fIds as $fid) {
                $family = Family::find($fid);
                $family->status = $status;
                $family->save();
                if (FamilyStatus::Active === $family->status) {
                    foreach ($family->members_info as $member) {
                        $member->status = MustahiqStatus::Active->value;
                        $member->updated_by = $request->updated_by;
                        $member->updated_at = now();
                        $member->save();
                    }
                }
            }
        });

        return response()->json(['success' => 'Selected families has been successfully updated.'], Response::HTTP_OK);
    }

    public function getList(Request $request): JsonResponse
    {
        $request->validate([
            "p" => ['nullable', 'numeric', Rule::exists(JProject::class, 'id')],
            "g" => ['nullable', 'numeric', Rule::exists(JGro::class, 'id')],
            "s" => ['nullable', new Enum(FamilyStatus::class)],
        ]);
        list($sort, $type, $query, $item) = getListValidation($request);
        $status = $request->input("s") ?? null;
        $projectId = $request->input("p") ?? null;
        $groId = $request->input("g") ?? null;
        $allGROs = [];
        $jeebika = Jeebika::select('j_project_id', 'j_gro_id', 'family_id');
        if ($projectId) {
            $jeebika = $jeebika->where('j_project_id', $projectId);
            $allGROs = JGro::select('id', 'name', 'j_project_id')->where('j_project_id', $projectId)->get();
        }
        if ($groId) {
            $jeebika = $jeebika->where('j_project_id', $projectId)->where('j_gro_id', $groId);
        }

        $data = Family::select('id', 'name', 'number_of_family_member', 'family_reference_number', 'status', 'created_at')
            ->whereIn('status', [FamilyStatus::Pending, FamilyStatus::Verified, FamilyStatus::Rejected])
            ->whereIn('id', $jeebika->pluck('family_id'))->when($status, fn($builder) => $builder->where('status', $status))->get();

        return response()->json([
            'lists'       => $data,
            'statuses'    => [FamilyStatus::Pending, FamilyStatus::Verified, FamilyStatus::Rejected],
            'allProjects' => JProject::select('id', 'name')->where('status', JGroStatus::Active)->get(),
            'allGROs'     => $allGROs
        ], Response::HTTP_OK);
    }

    public function viewById($id): Renderable
    {
        $family = Family::findOrFail($id);
        $m = Mustahiq::getTableName();
        $d = MustahiqDetail::getTableName();
        $f = Family::getTableName();
        $fm = FamilyMember::getTableName();

        $data = Family::with([
            'members' => function ($builder) {
                $builder->with(['mustahiq.details', 'mustahiq.vocationals.vocational', 'mustahiq.skills.skill', 'mustahiq.details.occupation', 'mustahiq.details.present_district', 'mustahiq.details.present_upazila', 'mustahiq.details.present_union',
                    'mustahiq.permanent_district', 'mustahiq.permanent_upazila', 'mustahiq.permanent_union', 'mustahiq.disability', 'mustahiq.disease',
                    'family']);
            },
            'jeebika', 'jeebika.j_project', 'jeebika.j_gro', 'assets', 'savings', 'expenses', 'incomes', 'loans', 'otherNgos', 'neighbourHelps', 'richHelps', 'safeties', 'disasters', 'conflictResolves'
        ])->findOrFail($id);
        return view('dashboard.jeebika.family-validation.view', compact('data'));
    }
}
