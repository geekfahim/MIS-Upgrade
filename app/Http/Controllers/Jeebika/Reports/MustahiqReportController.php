<?php

namespace App\Http\Controllers\Jeebika\Reports;

use App\Enums\MustahiqBloodGroup;
use App\Enums\MustahiqEducationLevel;
use App\Enums\MustahiqGender;
use App\Enums\MustahiqMaritalStatus;
use App\Enums\MustahiqOrphanType;
use App\Enums\MustahiqReligion;
use App\Enums\MustahiqStatus;
use App\Enums\OriginProgram;
use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyMember;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Mustahiq\MustahiqDetail;
use App\Models\Base\Settings\Disability;
use App\Models\Base\Settings\Disease;
use App\Models\Base\Settings\Occupation;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class MustahiqReportController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.jeebika.reports.mustahiq-report');
    }

    public function download(Request $request)
    {
        $disabilityArray = ['all', 'all_not_disable', 'all_disable'];
        $diseaseArray = ['all', 'all_not_disease', 'all_disease'];
        $orphanTypeArray = ['all', 'all_not_orphan', 'all_orphan'];
        $request->validate([
            'report_type' => ['required', 'in:pdf,xls,view'],
            'status' => ['nullable', new Enum(MustahiqStatus::class)],
            'marital_status' => ['nullable', new Enum(MustahiqMaritalStatus::class)],
            'gender' => ['nullable', new Enum(MustahiqGender::class)],
            'religion' => ['nullable', new Enum(MustahiqReligion::class)],
            'blood_group' => ['nullable', new Enum(MustahiqBloodGroup::class)],
            'orphan_type' => ['nullable', Rule::in(array_merge(json_decode(json_encode(MustahiqOrphanType::cases())), $orphanTypeArray))],
            'is_earn_ability' => ['nullable', 'in:yes,no'],
            'is_disease_regular_medicine' => ['nullable', 'in:yes,no'],
            'highest_education_level' => ['nullable', new Enum(MustahiqEducationLevel::class)],
            'age_from' => ['nullable', 'numeric'],
            'age_to' => [Rule::when($request->input('age_from'), ['required', 'after_or_equal:age_from'])],
            'disability_id' => ['nullable', Rule::in(array_merge($disabilityArray, Disability::pluck('id')->toArray()))],
            'disease_id' => ['nullable', Rule::in(array_merge($diseaseArray, Disease::pluck('id')->toArray()))],
            'occupation_id' => ['nullable', Rule::exists(Occupation::getTableName(), 'id')],
        ]);

        $report_type = $request->input("report_type");
        $status = $request->input("status") ?: null;
        $gender = $request->input("gender") ?: null;
        $religion = $request->input("religion") ?: null;
        $highest_education_level = $request->input("highest_education_level") ?: null;
        $isEarnAbility = $request->input("is_earn_ability") ?: null;
        $age_from = $request->input("age_from") ? getAgeToBirthday((int)$request->input("age_from")) : null;
        $age_to = $request->input("age_from") ? getAgeToBirthday((int)$request->input("age_to")) : null;
        $occupation_id = $request->input("occupation_id") ?: null;
        $disability_id = $request->input("disability_id") ?: null;
        $j_project_id = $request->input("j_project_id") ?: null;
        $j_gro_id = $request->input("j_gro_id") ?: null;
        $family_id = $request->input("family_id") ?: null;
        $isDiseaseRegularMedicine = $request->input("is_disease_regular_medicine") ?: null;
        $disease_id = $request->input("disease_id") ?: null;
        $bloodGroup = $request->input("blood_group") ?: null;
        $maritalStatus = $request->input("marital_status") ?: null;
        $orphanType = $request->input("orphan_type") ?: null;

        $m = Mustahiq::getTableName();
        $md = MustahiqDetail::getTableName();
        $o = Occupation::getTableName();
        $d = Disability::getTableName();
        $di = Disease::getTableName();
        $f = Family::getTableName();
        $fm = FamilyMember::getTableName();
        $j = Jeebika::getTableName();
        $p = JProject::getTableName();
        $g = JGro::getTableName();
        $data = Mustahiq::select(
            $m . '.id as id',
            $m . '.name as mustahiq_name',
            'gender',
            'religion',
            'blood_group',
            'nid',
            'is_disability',
            'reference_number',
            'mobile',
            'mobile',
            'birth_date',
            'highest_education_level',
            'is_earn_ability',
            'marital_status',
            'orphan_type',
            'is_disease_regular_medicine',
            'f.name as family_name',
            'p.name as project_name',
            'g.name as gro_name',
            'o.name as occupation_name',
            'd.name as disability_name',
            'di.name as disease_name',
        )
            ->join($md . ' as md', 'md.mustahiq_id', '=', $m . '.id')
            ->join($fm . ' as fm', 'fm.mustahiq_id', '=', $m . '.id')
            ->leftJoin($d . ' as d', 'd.id', '=', $m . '.disability_id')
            ->leftJoin($di . ' as di', 'di.id', '=', $m . '.disease_id')
            ->join($f . ' as f', 'f.id', '=', 'fm.family_id')
            ->join($j . ' as j', 'j.family_id', '=', 'fm.family_id')
            ->join($p . ' as p', 'p.id', '=', 'j.j_project_id')
            ->join($g . ' as g', 'g.id', '=', 'j.j_gro_id')
            ->leftJoin($o . ' as o', 'o.id', '=', 'md.occupation_id')
            ->when($status, function ($builder) use ($m, $status) {
                $builder->where($m . '.status', $status);
            })
            ->when($maritalStatus, function ($builder) use ($maritalStatus) {
                $builder->where('marital_status', $maritalStatus);
            })
            ->when($gender, function ($builder) use ($gender) {
                $builder->where('gender', $gender);
            })
            ->when($bloodGroup, function ($builder) use ($bloodGroup) {
                $builder->where('blood_group', $bloodGroup);
            })
            ->when($religion, function ($builder) use ($religion) {
                $builder->where('religion', $religion);
            })
            ->when($orphanType, function ($builder) use ($orphanType) {
                $orphanType == 'all_not_orphan' ? $builder->where('is_orphan', 0) : ($orphanType == 'all_orphan' ? $builder->where('is_orphan', 1) : $builder->where('orphan_type', '=', $orphanType));
            })
            ->when($highest_education_level, function ($builder) use ($highest_education_level) {
                $builder->where('highest_education_level', $highest_education_level);
            })
            ->when($occupation_id, function ($builder) use ($occupation_id) {
                $builder->where('occupation_id', $occupation_id);
            })
            ->when($isEarnAbility, function ($builder) use ($isEarnAbility) {
                $isEarnAbility == 'yes' ? $builder->where('is_earn_ability', 1) : $builder->where('is_earn_ability', 0);
            })
            ->when($isDiseaseRegularMedicine, function ($builder) use ($isDiseaseRegularMedicine) {
                $isDiseaseRegularMedicine == 'yes' ? $builder->where('is_disease_regular_medicine', 1) : $builder->where('is_disease_regular_medicine', 0);
            })
            ->when($disability_id, function ($builder) use ($disability_id) {
                $disability_id == 'all_not_disable' ? $builder->where('is_disability', 0) : ($disability_id == 'all_disable' ? $builder->where('is_disability', 1) : $builder->where('disability_id', '=', $disability_id));
            })
            ->when($disease_id, function ($builder) use ($disease_id) {
                $disease_id == 'all_not_disease' ? $builder->where('is_disease', 0) : ($disease_id == 'all_disease' ? $builder->where('is_disease', 1) : $builder->where('disease_id', '=', $disease_id));
            })
            ->when($age_from && $age_to, function ($builder) use ($age_from, $age_to) {
                $builder->whereBetween('birth_date', [$age_to, $age_from]);
            })
            ->when($j_project_id, function ($builder) use ($j_project_id) {
                $builder->where('j.j_project_id', $j_project_id);
            })
            ->when($j_gro_id, function ($builder) use ($j_gro_id) {
                $builder->where('j.j_gro_id', $j_gro_id);
            })
            ->when($family_id, function ($builder) use ($family_id) {
                $builder->where('j.family_id', $family_id);
            })
            ->where($m . '.origin_program', OriginProgram::JEEBIKA)
            ->get();

        /*if ($report_type == 'pdf') {
            $file_name = "Report_summary_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.mustahiq-report', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }*/
        if ($report_type == 'xls') {
            $file_name = "Report_mustahiq_demographic_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.jeebika.download.mustahiq-report', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ($report_type == 'view') {
            return view('dashboard.jeebika.download.mustahiq-report', compact('data'));
        }
    }
}
