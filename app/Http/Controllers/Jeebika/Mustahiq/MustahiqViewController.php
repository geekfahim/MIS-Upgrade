<?php

namespace App\Http\Controllers\Jeebika\Mustahiq;

use App\Enums\MustahiqBloodGroup;
use App\Enums\MustahiqEducationLevel;
use App\Enums\MustahiqGender;
use App\Enums\MustahiqMaritalStatus;
use App\Enums\MustahiqOrphanType;
use App\Enums\MustahiqPregnancyStatus;
use App\Enums\MustahiqReligion;
use App\Enums\MustahiqStatus;
use App\Enums\OriginProgram;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyMember;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Mustahiq\MustahiqDetail;
use App\Models\Base\Settings\Disability;
use App\Models\Base\Settings\Disease;
use App\Models\Base\Settings\District;
use App\Models\Base\Settings\Occupation;
use App\Models\Base\Settings\Sponsor;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MustahiqViewController extends Controller
{

    public function index(): Renderable
    {
        return view('dashboard.jeebika.mustahiq.view-mustahiqs');
    }

    public function getList(Request $request): JsonResponse
    {
        $disabilityArray = ['all_not_disable', 'all_disable'];
        list($sort, $type, $query, $item) = getListValidation($request);
        $project = (session('s_j_project_id') ?: $request->input("project")) ?? null;
        $gro = $request->input("gro") ?? null;
        $status = $request->input("status") ?? null;
        $gender = $request->input("gender") ?? null;
        $religion = $request->input("religion") ?? null;
        $bloodGroup = $request->input("bg") ?? null;
        $disability = $request->input("disability") ?? null;
        $disease = $request->input("disease") ?? null;
        $regularMedicine = $request->input("rm") ?? null;
        $sponsor = $request->input("sponsor") ?? null;
        $orphan = $request->input("orphan") ?? null;
        $pregnancy = $request->input("pregnancy") ?? null;
        $maritalStatus = $request->input("marital") ?? null;
        $highestEducationLevel = $request->input("hel") ?? null;
        $earnAbility = $request->input("ea") ?? null;
        $occupation = $request->input("occupation") ?? null;
        $permanentDistrict = $request->input("ped") ?? null;
        $presentDistrict = $request->input("prd") ?? null;

        $m = Mustahiq::getTableName();
        $d = MustahiqDetail::getTableName();
        $j = Jeebika::getTableName();
        $fm = FamilyMember::getTableName();
        $data = Mustahiq::join($d . ' as d', $m . '.id', '=', 'd.mustahiq_id')
            ->select([
                $m . '.id as id',
                $m . '.created_at as created_at',
                'name',
                'gender',
                'religion',
                'blood_group',
                'is_disability',
                'sponsor_id',
                'is_orphan',
                'orphan_type',
                'pregnancy_status',
                'marital_status',
                'highest_education_level',
                'is_earn_ability',
                'occupation_id',
                'permanent_district_id',
                'present_district_id',
                'status',
                'origin_program',
                'd.is_earn_ability'
            ])
            ->when($query, function ($builder) use ($query) {
                $builder->where('name', 'LIKE', '%' . $query . '%')
                    ->orWhere('gender', 'LIKE', '%' . $query . '%')
                    ->orWhere('religion', 'LIKE', '%' . $query . '%')
                    ->orWhere('status', 'LIKE', '%' . $query . '%');
            })
            ->when($project, function ($builder) use ($j, $fm, $m, $project, $gro) {
                $builder->join($fm . ' as fm', 'fm.mustahiq_id', '=', $m . '.id')
                    ->join($j . ' as  j', 'j.family_id', '=', 'fm.family_id')
                    ->where('j.j_project_id', '=', $project)
                    ->when($gro, function ($builder) use ($gro) {
                        $builder->where('j.j_gro_id', '=', $gro);
                    });
            })
            ->when($gender, function ($builder) use ($gender) {
                $builder->where("gender", $gender);
            })
            ->when($religion, function ($builder) use ($religion) {
                $builder->where("religion", $religion);
            })
            ->when($bloodGroup, function ($builder) use ($bloodGroup) {
                $builder->where("blood_group", $bloodGroup);
            })
            ->when($disability, function ($builder) use ($disabilityArray, $disability) {
                $builder->when($disability == 'all_not_disable', function ($builder) {
                    $builder->where('is_disability', 0);
                })
                    ->when($disability == 'all_disable', function ($builder) {
                        $builder->where('is_disability', 1);
                    })
                    ->when(!in_array($disability, $disabilityArray), function ($builder) use ($disability) {
                        $builder->where('disability_id', $disability);
                    });
            })
            ->when($disease, function ($builder) use ($disease) {
                $disease == 'all_not_disease' ? $builder->where('is_disease', 0) : ($disease == 'all_disease' ? $builder->where('is_disease', 1) : $builder->where('disease_id', '=', $disease));
            })
            ->when($regularMedicine, function ($builder) use ($regularMedicine) {
                $regularMedicine == 'Yes' ? $builder->where('is_disease_regular_medicine', 1) : $builder->where("is_disease_regular_medicine", 0);
            })
            ->when($sponsor, function ($builder) use ($sponsor) {
                $builder->where("sponsor_id", $sponsor);
            })
            ->when($orphan, function ($builder) use ($orphan) {
                $orphan == 'all_not_orphan' ? $builder->where('is_orphan', 0) : ($orphan == 'all_orphan' ? $builder->where('is_orphan', 1) : $builder->where("orphan_type", $orphan));
            })
            ->when($pregnancy, function ($builder) use ($pregnancy) {
                $builder->where("pregnancy_status", $pregnancy);
            })
            ->when($maritalStatus, function ($builder) use ($maritalStatus) {
                $builder->where("marital_status", $maritalStatus);
            })
            ->when($highestEducationLevel, function ($builder) use ($highestEducationLevel) {
                $builder->where("highest_education_level", $highestEducationLevel);
            })
            ->when($earnAbility, function ($builder) use ($earnAbility) {
                $earnAbility == 'Yes' ? $builder->where("is_earn_ability", 1) : $builder->where("is_earn_ability", 0);
            })
            ->when($occupation, function ($builder) use ($occupation) {
                $builder->where("occupation_id", $occupation);
            })
            ->when($permanentDistrict, function ($builder) use ($permanentDistrict) {
                $builder->where("permanent_district_id", $permanentDistrict);
            })
            ->when($presentDistrict, function ($builder) use ($presentDistrict) {
                $builder->where("present_district_id", $presentDistrict);
            })
            ->when($status, function ($builder) use ($status) {
                $builder->where("status", $status);
            })
            ->where('origin_program', OriginProgram::JEEBIKA)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists'              => $data,
            "projects"           => JProject::select(['id', 'name'])->when(session('s_j_project_id'), function ($builder) {
                $builder->where('id', session('s_j_project_id'));
            })->get(),
            "GROs"               => $project ? JGro::getAllByProjectId($project, ['id', 'name']) : null,
            "STATUSES"           => MustahiqStatus::cases(),
            'GENDERS'            => MustahiqGender::cases(),
            'RELIGIONS'          => MustahiqReligion::cases(),
            "BLOOD_GROUPS"       => MustahiqBloodGroup::cases(),
            "diseases"           => Disease::all(['id', 'name']),
            "disabilities"       => Disability::all(['id', 'name']),
            "YES_NO"             => ['No', 'Yes'],
            "sponsors"           => Sponsor::getAll(),
            "ORPHAN_TYPES"       => MustahiqOrphanType::cases(),
            'PREGNANCY_STATUSES' => MustahiqPregnancyStatus::cases(),
            'MARITAL_STATUS'     => MustahiqMaritalStatus::cases(),
            'EDUCATION_LEVELS'   => MustahiqEducationLevel::cases(),
            "occupations"        => Occupation::all(['id', 'name']),
            "districts"          => District::all(['id', 'name']),
        ], Response::HTTP_OK);

    }

}
