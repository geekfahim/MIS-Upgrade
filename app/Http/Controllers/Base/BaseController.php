<?php

namespace App\Http\Controllers\Base;

use App\Enums\FamilyConflictResolveType;
use App\Enums\FamilyCookingFuelType;
use App\Enums\FamilyDisasterLevel;
use App\Enums\FamilyDrinkingWaterSource;
use App\Enums\FamilyElectricityConnectivityType;
use App\Enums\FamilyExpenseType;
use App\Enums\FamilyHeadedByType;
use App\Enums\FamilyHouseLandType;
use App\Enums\FamilyHouseLocation;
use App\Enums\FamilyHouseType;
use App\Enums\FamilyLoanPurposeType;
use App\Enums\FamilyLoanSourceType;
use App\Enums\FamilyNeighbourHelpType;
use App\Enums\FamilyOtherNGOHelpType;
use App\Enums\FamilyOtherWaterSource;
use App\Enums\FamilyRelationType;
use App\Enums\FamilyRichHelpType;
use App\Enums\FamilySafetyAbuserRelationType;
use App\Enums\FamilySafetyAbuseType;
use App\Enums\FamilySavingType;
use App\Enums\FamilyStatus;
use App\Enums\FamilyToiletOwnershipType;
use App\Enums\FamilyToiletType;
use App\Enums\JGroStatus;
use App\Enums\JProjectStatus;
use App\Enums\MustahiqBloodGroup;
use App\Enums\MustahiqEducationLevel;
use App\Enums\MustahiqGender;
use App\Enums\MustahiqLivingStatus;
use App\Enums\MustahiqMaritalStatus;
use App\Enums\MustahiqOrphanType;
use App\Enums\MustahiqPregnancyStatus;
use App\Enums\MustahiqRelationalLivingStatus;
use App\Enums\MustahiqReligion;
use App\Enums\MustahiqStatus;
use App\Enums\OriginProgram;
use App\Enums\SponsorStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Acl\User;
use App\Models\Base\Family\Family;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Settings\Asset;
use App\Models\Base\Settings\Bank;
use App\Models\Base\Settings\Disability;
use App\Models\Base\Settings\Disaster;
use App\Models\Base\Settings\Disease;
use App\Models\Base\Settings\District;
use App\Models\Base\Settings\Income;
use App\Models\Base\Settings\Occupation;
use App\Models\Base\Settings\Recover;
use App\Models\Base\Settings\Skill;
use App\Models\Base\Settings\Sponsor;
use App\Models\Base\Settings\Union;
use App\Models\Base\Settings\Upazila;
use App\Models\Base\Settings\Vocational;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BaseController extends Controller
{
    /* Read Notification Start */
    public function readNotification(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        if (isset($notification->data['route_name']) && !empty($notification->data['route_name'])) return redirect(route($notification->data['route_name']));
        return redirect()->back();
    }
    /* Read Notification End */

    /* Search Start */
    public function userSearch(Request $request): JsonResponse
    {
        $query = (string)$request->get('q');
        $data = User::select("id", "name as text", 'office_id', 'email', 'is_admin', 'status', 'created_at')
            ->where(function ($sql) use ($query) {
                $sql->where("name", "LIKE", "%" . $query . "%")
                    ->orWhere("office_id", "LIKE", "%" . $query . "%");
            })->where('status', UserStatus::Active)->where('is_admin', false)->orderBy('text')->get();
        $mappedData = $data->map(function ($item) {
            return ["id" => $item->id, "text" => $item->text . " (" . $item->office_id . ")"];

        });
        return response()->json($mappedData, Response::HTTP_OK);
    }

    public function groFamilyHeadSearch(Request $request, $gid): JsonResponse
    {
        $query = (string)$request->get('q');
        $m = Mustahiq::getTableName();
        $f = Family::getTableName();
        $data = Jeebika::join($f . ' as f', 'f.id', '=', 'family_id')->join($m . ' as m', 'm.id', '=', 'f.family_head_id')
            ->where(function ($sql) use ($query) {
                $sql->where("m.name", "LIKE", "%" . $query . "%");
            })->select('m.id as id', 'm.name as text')->where('j_gro_id', $gid)->get();

        return response()->json($data, Response::HTTP_OK);
    }

    public function sponsorSearch(Request $request): JsonResponse
    {
        $query = (string)$request->get('q');
        $data = Sponsor::select("id", "name as text", 'status')->where(function ($sql) use ($query) {
            $sql->where("name", "LIKE", "%" . $query . "%");
        })->where('status', SponsorStatus::Active)->orderBy('text')->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function projectSearch(Request $request): JsonResponse
    {
        $query = (string)$request->get('q');
        $data = JProject::select("id", "name as text", 'status')->where(function ($sql) use ($query) {
            $sql->where("name", "LIKE", "%" . $query . "%");
        })->where('status', JGroStatus::Active)->orderBy('text')->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function familySearch(Request $request): JsonResponse
    {
        $request->validate(['gid' => ['sometimes', Rule::exists(JGro::getTableName(), 'id')]]);
        $familyIds = $request->gid ? Jeebika::where('j_gro_id', $request->gid)->pluck('family_id') : null;
        $query = (string)$request->get('q');
        $data = Family::select("id", "name as text", "status")->when($familyIds, function ($sql) use ($familyIds) {
            $sql->whereIn('id', $familyIds);
        })->where(function ($sql) use ($query) {
            $sql->where("name", "LIKE", "%" . $query . "%");
        })->where('status', FamilyStatus::Active->value)->orderBy('text')->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function mustahiqSearch(Request $request): JsonResponse

    {
        $request->validate(['project_type' => ['sometimes', new Enum(OriginProgram::class)]]);
        $query = (string)$request->get('q');
        $data = Mustahiq::select("id", "name as text", 'status')
            ->where(function ($sql) use ($query) {
                $sql->where("name", "LIKE", "%" . $query . "%");
            })
            ->when($request->project_type, function ($builder) use ($request) {
                $builder->where('origin_program', $request->project_type);
            })->where('status', MustahiqStatus::Active->value)->orderBy('text')->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function districtSearch(Request $request): JsonResponse
    {
        $query = (string)$request->get('q');
        $data = District::select("id", "name as text")->where(function ($sql) use ($query) {
            $sql->where("name", "LIKE", "%" . $query . "%");
        })->orderBy('text')->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function upazilaSearch(Request $request): JsonResponse
    {
        if ($request->has('district_id')) {
            $items = Upazila::where('district_id', $request->district_id)->get()->map(function ($item) {
                return $item->only('id', 'name');
            });
            return response()->json($items, Response::HTTP_OK);
        }
        $query = (string)$request->get('q');
        $data = Upazila::select("id", "name as text")->where(function ($sql) use ($query) {
            $sql->where("name", "LIKE", "%" . $query . "%");
        })->orderBy('text')->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function unionSearch(Request $request): JsonResponse
    {
        if ($request->has('upazila_id')) {
            $items = Union::where('upazila_id', $request->upazila_id)->get()->map(function ($item) {
                return $item->only('id', 'name');
            });
            return response()->json($items, Response::HTTP_OK);
        }
        $query = (string)$request->get('q');
        $data = Union::select("id", "name as text")->where(function ($sql) use ($query) {
            $sql->where("name", "LIKE", "%" . $query . "%");
        })->orderBy('text')->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function bankSearch(Request $request): JsonResponse
    {
        $query = (string)$request->get('q');
        $data = Bank::select("id", "name as text")->where(function ($sql) use ($query) {
            $sql->where("name", "LIKE", "%" . $query . "%");
        })->orderBy('text')->get();

        return response()->json($data, Response::HTTP_OK);
    }
    /* Search End */

    /* Request Start */
    public function initData(Request $request): array
    {
        $request->validate([
            'pid' => ['sometimes', Rule::exists(JProject::getTableName(), 'id')]
        ]);
        if ($request->pid) {
            $project = JProject::find($request->pid);
            $data['sponsors'] = Sponsor::select('id', 'name')->whereIn('id', $project->sponsors()->pluck('sponsor_id'))->get();
            $data['GROs'] = JGro::getAllByProjectId($project->id, ['id', 'name']);
            return $data;
        }
        $data = [
            //mustahiq & member
            "maritalStatuses" => MustahiqMaritalStatus::cases(),
            "mustahiqLivingStatus" => MustahiqLivingStatus::cases(),
            "relationalLivingStatus" => MustahiqRelationalLivingStatus::cases(),
            "educationLevels" => MustahiqEducationLevel::cases(),
            "vocationals" => Vocational::getAll(['id', 'name as text']),
            "skills" => Skill::getAll(['id', 'name as text']),
            "genders" => MustahiqGender::cases(),
            "pregnancyStatuses" => MustahiqPregnancyStatus::cases(),
            "orphanTypes" => MustahiqOrphanType::cases(),
            "religions" => MustahiqReligion::cases(),
            "bloodGroups" => MustahiqBloodGroup::cases(),
            "disabilities" => Disability::getAll(),
            "diseases" => Disease::getAll(),
            "familyRelationTypes" => FamilyRelationType::cases(),
            "occupations" => Occupation::getAll(),
            "districts" => District::getAll(),
            //family info
            "familyHeadedByTypes" => FamilyHeadedByType::cases(),
            "houseTypes" => FamilyHouseType::cases(),
            "houseLandTypes" => FamilyHouseLandType::cases(),
            "houseLocations" => FamilyHouseLocation::cases(),
            "drinkingWaterSources" => FamilyDrinkingWaterSource::cases(),
            "otherWaterSources" => FamilyOtherWaterSource::cases(),
            "toiletTypes" => FamilyToiletType::cases(),
            "toiletOwnershipTypes" => FamilyToiletOwnershipType::cases(),
            "cookingFuelTypes" => FamilyCookingFuelType::cases(),
            "electricityConnectivityTypes" => FamilyElectricityConnectivityType::cases(),
            //family savings
            "savingsTypes" => FamilySavingType::cases(),
            "assets" => Asset::getAll(),
            "loanSourceTypes" => FamilyLoanSourceType::cases(),
            "loanPurposeTypes" => FamilyLoanPurposeType::cases(),
            //family income & expense
            "incomes" => Income::getAll(),
            "expenseTypes" => FamilyExpenseType::cases(),
            //family NGO
            "ngoHelpTypes" => FamilyOtherNGOHelpType::cases(),
            //family safety & helpfulness
            "abuseTypes" => FamilySafetyAbuseType::cases(),
            "abuserRelationTypes" => FamilySafetyAbuserRelationType::cases(),
            "neighborHelpTypes" => FamilyNeighbourHelpType::cases(),
            "richHelpTypes" => FamilyRichHelpType::cases(),
            "conflictResolveTypes" => FamilyConflictResolveType::cases(),
            //family disaster & recovery
            "disasters" => Disaster::getAll(),
            "disasterLevels" => FamilyDisasterLevel::cases(),
            "recoveries" => Recover::getAll(),
        ];
        //check project manager login or Admin login
        if (session('s_j_project_id') && $project = JProject::find(session('s_j_project_id'))) {
            $data['sponsors'] = Sponsor::select('id', 'name')->whereIn('id', $project->sponsors()->pluck('sponsor_id'))->get();
            $data['projects'] = JProject::getAll(['id', 'name'])->where('id', session('s_j_project_id'));
            $data['GROs'] = JGro::getAllByProjectId($project->id);
        } else {
            $data['projects'] = JProject::getAll(['id', 'name']);
            $data['GROs'] = [];
            $data['sponsors'] = [];
        }
        return $data;
    }

    public function getMustahiqInit(): JsonResponse
    {
        $data = [
            "genders" => MustahiqGender::cases(),
            "religions" => MustahiqReligion::cases(),
            "disabilities" => Disability::getAll(),
            "occupations" => Occupation::getAll(),
            "mustahiqStatuses" => MustahiqStatus::cases(),
            "educations" => MustahiqEducationLevel::cases(),
            "bloodGroups" => MustahiqBloodGroup::cases(),
            "diseases" => Disease::getAll(),
            "maritalStatuses" => MustahiqMaritalStatus::cases(),
            "orphanTypes" => MustahiqOrphanType::cases(),
        ];
        //check project manager login or Admin login
        $data['projects'] = JProject::select(['id', 'name'])->when(session('s_j_project_id'), function ($builder) {
            $builder->where('id', session('s_j_project_id'));
        })->get();
        if (session('s_j_project_id')) {
            $data['GROs'] = JGro::getAllByProjectId(session('s_j_project_id'));
        } else {
            $data['GROs'] = [];
        }
        return response()->json($data, Response::HTTP_OK);
    }

    public function getReportFamilyInit(): JsonResponse
    {

        $jProject = JProject::select('id', 'name')->whereStatus(JProjectStatus::Active)
            ->when(session('s_j_project_id'), function ($builder) {
                $builder->where('id', session('s_j_project_id'));
            })->get();
        return response()->json($jProject, Response::HTTP_OK);
    }

    public function getFamiliesByProjectAndOrGRO(Request $request): JsonResponse
    {
        $request->validate([
            'j_project_id' => ['required', Rule::exists(JProject::getTableName(), 'id')],
            'j_gro_id' => ['nullable', Rule::exists(JGro::getTableName(), 'id')],
        ], [
            'j_project_id.required' => 'the project field is required'
        ]);
        $jProject = JProject::find($request->j_project_id);
        $selected = ['j_project_id', 'family_id'];
        $jGRO = null;
        if ($request->j_gro_id) {
            $jGRO = JGro::findOrFail($request->j_gro_id);
            $selected = array_merge($selected, ['j_gro_id']);
        }
        $data = Jeebika::with(['family' => function ($builder) {
            $builder->whereStatus(FamilyStatus::Active);
        }])
            ->select($selected)->where('j_project_id', $jProject->id)
            ->when($jGRO, function ($builder) use ($jGRO) {
                $builder->where('j_gro_id', $jGRO->id);
            })
            ->whereRelation('family', 'status', FamilyStatus::Active)
            ->get();

        return response()->json($data, Response::HTTP_OK);
    }

    public function getGROByProjectId(Request $request): JsonResponse
    {
        $request->validate([
            'j_project_id' => ['required', Rule::exists(JProject::getTableName(), 'id')],
        ],
            [
                'j_project_id.required' => 'the project field is required'
            ]);
        $data = JGro::select('id', 'name')->where('j_project_id', $request->j_project_id)->get();
        return response()->json($data, Response::HTTP_OK);
    }


    /* Request End */
}
