<?php

use App\Enums\FamilyStatus;
use App\Enums\IGA\JBusinessPlanStatus;
use App\Enums\IGA\JInvestmentStatus;
use App\Enums\JGroStatus;
use App\Enums\JProjectStatus;
use App\Enums\JTrainingStatus;
use App\Enums\MustahiqStatus;
use App\Enums\OriginProgram;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyMember;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Mustahiq\MustahiqDetail;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\IGA\JFamilyBalance;
use App\Models\Jeebika\IGA\JInvestment;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JImplementationPlan;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Training\JTraining;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

if (!function_exists('customSoftDelete')) {
    function customSoftDelete($class, $data): void
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }
        $data['deleted_at'] = now();
        $class::insert($data);
    }
}
if (!function_exists('removeEmptyKey')) {
    function removeEmptyKey($values): array
    {
        if ($values instanceof Arrayable) {
            $values = $values->toArray();
        }
        return array_filter($values, function ($item) {
            return $item !== "" && $item !== null;
        });
    }
}
if (!function_exists('getDefaultFromDate')) {
    function getDefaultFromDate(): string
    {
        return Carbon::parse('01-01-2008');
    }
}
if (!function_exists('getDefaultToDate')) {
    function getDefaultToDate(): string
    {
        return now();
    }
}
if (!function_exists('getItemPerPage')) {
    function getItemPerPage(int $item = 25): int
    {
        return $item;
    }
}
if (!function_exists('getDefaultAvatar')) {
    function getDefaultAvatar(): string
    {
        return "assets/images/avatars/default.jpg";
    }
}
if (!function_exists('getListValidation')) {
    function getListValidation(Request $request, string $sort = 'name,created_at', string $item = '25,50,100,200'): array
    {
        $request->validate([
            "page"  => ['nullable', 'numeric', 'digits_between:1,10'],
            "sort"  => ['nullable', 'in:' . $sort],
            "type"  => ['nullable', 'in:asc,desc'],
            "query" => ['nullable', 'string', 'max:50'],
            "item"  => ['nullable', 'in:' . $item],
        ]);
        $sort = $request->input("sort") ?? 'created_at';
        $type = $request->input("type") ?? "asc";
        $query = $request->input("query");
        $item = $request->input("item") ?? getItemPerPage();
        return [$sort, $type, $query, $item];
    }
}
if (!function_exists('getPDFOptions')) {
    function getPDFOptions(): array
    {
        return [
            'footer-left'      => 'Print Date: [date] [time]',
            'footer-right'     => 'Page [page] of [topage]',
            'footer-center'    => 'This is ' . config('app.name') . ' generated report by ' . auth()->user()->name . ' - ' . auth()->user()->email,
            'footer-font-size' => '8',
            'footer-spacing'   => '8',
            'margin-bottom'    => '17',
        ];
    }
}
if (!function_exists('deleteAssetFile')) {
    function deleteAssetFile($asset_path, $id = null, $disk = 'public', $folder = null): bool
    {
        if ($asset_path) {
            $file = explode("/", $asset_path);
            $file = end($file);
            if ($folder) {
                $file = $folder . "/" . $file;
            }
            if ($id) {
                $file = $id . "/" . $file;
            }
            if ($file && Storage::disk($disk)->exists($file)) {
                Storage::disk($disk)->delete($file);
                return TRUE;
            }
        }
        return FALSE;
    }
}
if (!function_exists('getAgeToBirthday')) {
    function getAgeToBirthday(int $age): string
    {
        return Carbon::now()->copy()->year - $age . '-01-01';
    }
}
if (!function_exists('getActiveProjectCount')) {
    function getActiveProjectCount(): int
    {
        return JProject::whereStatus(JGroStatus::Active)->count();
    }
}
/*Dashboards*/
if (!function_exists('getActiveGROCount')) {
    function getActiveGROCount(): int
    {
        return JGro::whereStatus(JGroStatus::Active)->count();
    }
}
if (!function_exists('getActiveFamilyCount')) {
    function getActiveFamilyCount(): int
    {
        return Family::whereStatus(FamilyStatus::Active)->count();
    }
}
if (!function_exists('getActiveMustahiqCount')) {
    function getActiveMustahiqCount(): int
    {
        return Mustahiq::whereStatus(MustahiqStatus::Active)
            ->where('origin_program', OriginProgram::JEEBIKA)
            ->count();
    }
}
if (!function_exists('getActiveDisableMustahiqCount')) {
    function getActiveDisableMustahiqCount(): int
    {
        return Mustahiq::whereStatus(MustahiqStatus::Active)
            ->where('origin_program', OriginProgram::JEEBIKA)
            ->whereIsDisability(1)
            ->count();
    }
}
if (!function_exists('getFamilyMemberCount')) {
    function getFamilyMemberCount(): int
    {
        return FamilyMember::count();
    }
}
if (!function_exists('getUpcomingTrainingCount')) {
    function getUpcomingTrainingCount()
    {
        return JTraining::whereStatus(JTrainingStatus::Upcoming)->projectManager()->count();
    }
}
if (!function_exists('getActiveBusinessCount')) {
    function getActiveBusinessCount(): int
    {
        return JBusinessPlan::projectManager()->where(fn($builder) => $builder->where('status', JBusinessPlanStatus::Ongoing)->orWhere('status', JBusinessPlanStatus::Approved))->count();
    }
}
if (!function_exists('getProjectDistrictCount')) {
    function getProjectDistrictCount(): int
    {
        return JProject::whereStatus(JProjectStatus::Active)->distinct()->count('district_id');
    }
}
if (!function_exists('getOutstandingBalanceGroTotalAmount')) {
    function getOutstandingBalanceGroTotalAmount(): int
    {
        return JFamilyBalance::projectManager()->sum('balance');
    }
}
if (!function_exists('getInvestmentTotalAmount')) {
    function getInvestmentTotalAmount(): int
    {
        return JInvestment::projectManager()->whereStatus(JInvestmentStatus::Approved)->sum('approved_amount');
    }
}
if (!function_exists('getActivitiesAllCount')) {
    function getActivitiesAllCount(): int
    {
        return JImplementationPlan::projectManager()->count();
    }
}
if (!function_exists('getActivitiesMonthlyCount')) {
    function getActivitiesMonthlyCount($status = null)
    {
        return JImplementationPlan::projectManager()->whereMonth('possible_implementation_date', Carbon::now()->month)->when($status, fn($builder) => $builder->whereImplementStatus($status))->count();
    }
}
/*GRO*/
if (!function_exists('getActiveGroFamilyCount')) {
    function getActiveGroFamilyCount(): int
    {
        $groId = Route::current()->parameter('id');
        return Jeebika::where('j_gro_id', $groId)->count('family_id');
    }
}
if (!function_exists('getActiveGroMustahiqCount')) {
    function getActiveGroMustahiqCount(): int
    {
        $groId = Route::current()->parameter('id');
        $data = Jeebika::with(['family' => function ($builder) {
            $builder->withCount('members');
        }])->where('j_gro_id', $groId)->get();
        $member = 0;
        foreach ($data as $item) {
            $member += $item->family->members_count;
        }
        return $member;
    }
}
if (!function_exists('getActiveGroDisableMustahiqCount')) {
    function getActiveGroDisableMustahiqCount(): int
    {
        $groId = Route::current()->parameter('id');

        $data = Jeebika::with(['family' => function ($builder) {
            $builder->withcount(['members_info' => function ($builder1) {
                $builder1->where('is_disability', 1);
            }]);
        }])->where('j_gro_id', $groId)->get();
        $member = 0;
        foreach ($data as $item) {
            $member += $item->family->members_info_count;
        }
        return $member;
    }
}
if (!function_exists('getActiveGroBusinessCount')) {
    function getActiveGroBusinessCount(): int
    {
        $groId = Route::current()->parameter('id');
        return JBusinessPlan::where('status', JBusinessPlanStatus::Ongoing)->orWhere('status', JBusinessPlanStatus::Approved)->where('j_gro_id', $groId)->count();
    }
}
if (!function_exists('getOutstandingGroBalance')) {
    function getOutstandingGroBalance(): int
    {
        $groId = Route::current()->parameter('id');
        return JFamilyBalance::where('j_gro_id', $groId)->sum('balance');
    }
}
if (!function_exists('getInvestmentGroTotalAmount')) {
    function getInvestmentGroTotalAmount(): int
    {
        $groId = Route::current()->parameter('id');
        return JInvestment::whereStatus(JInvestmentStatus::Approved)->where('j_gro_id', $groId)->sum('approved_amount');
    }
}
/*project dashboard*/
if (!function_exists('getProjectGroCount')) {
    function getProjectGroCount()
    {
        $projectId = session('s_j_project_id') ?: Route::current()->parameter('id');
        return JGro::where('j_project_id', $projectId)->count();
    }
}
if (!function_exists('getProjectFamilyCount')) {
    function getProjectFamilyCount(): int
    {
        $projectId = session('s_j_project_id') ?: Route::current()->parameter('id');
        return Jeebika::whereRelation('family', 'status', FamilyStatus::Active)->where('j_project_id', $projectId)->count('family_id');
    }
}
if (!function_exists('getProjectFamilyMemberCount')) {
    function getProjectFamilyMemberCount(): int
    {
        $projectId = session('s_j_project_id') ?: Route::current()->parameter('id');
        $data = Jeebika::whereRelation('family', 'status', FamilyStatus::Active)->with(['family' => function ($builder) {
            $builder->withCount('members');
        }])->where('j_project_id', $projectId)->get();
        $member = 0;
        foreach ($data as $item) {
            $member += $item->family->members_count;
        }
        return $member;
    }
}
if (!function_exists('getProjectDisableMustahiqCount')) {
    function getProjectDisableMustahiqCount(): int
    {
        $projectId = Route::current()->parameter('id');
        $data = Jeebika::with(['family' => function ($builder) {
            $builder->withcount(['members_info' => function ($builder1) {
                $builder1->where('is_disability', 1);
            }]);
        }])->where('j_project_id', $projectId)->get();
        $member = 0;
        foreach ($data as $item) {
            $member += $item->family->members_info_count;
        }
        return $member;
    }
}
if (!function_exists('getActiveProjectBusinessCount')) {
    function getActiveProjectBusinessCount(): int
    {
        $projectId = Route::current()->parameter('id');

        return JBusinessPlan::where('status', JBusinessPlanStatus::Ongoing)
            ->orWhere('status', JBusinessPlanStatus::Approved)
            ->where('j_project_id', $projectId)
            ->count();
    }
}
if (!function_exists('getProjectOutstandingBalance')) {
    function getProjectOutstandingBalance(): int
    {
        $projectId = session('s_j_project_id') ?: Route::current()->parameter('id');
        return JFamilyBalance::where('j_project_id', $projectId)->sum('balance');
    }
}
if (!function_exists('getProjectInvestmentTotalAmount')) {
    function getProjectInvestmentTotalAmount(): int
    {
        $projectId = session('s_j_project_id') ?: Route::current()->parameter('id');
        return JInvestment::whereStatus(JInvestmentStatus::Approved)->where('j_project_id', $projectId)->sum('approved_amount');
    }
}
if (!function_exists('getProjectAllActivitiesCount')) {
    function getProjectAllActivitiesCount(): int
    {
        $projectId = Route::current()->parameter('id');
        return JImplementationPlan::where('j_project_id', $projectId)->count();
    }
}
if (!function_exists('getProjectActivitiesMonthlyCount')) {
    function getProjectActivitiesMonthlyCount($status = null)
    {
        $projectId = Route::current()->parameter('id');
        return JImplementationPlan::whereMonth('possible_implementation_date', Carbon::now()->month)->where('j_project_id', $projectId)->when($status, function ($builder) use ($status) {
            $builder->whereImplementStatus($status);
        })->count();
    }
}
/*Project Admin*/
