<?php

namespace App\Http\Controllers\Base;

use App\Enums\MustahiqEducationLevel;
use App\Enums\MustahiqGender;
use App\Enums\MustahiqReligion;
use App\Enums\MustahiqStatus;
use App\Enums\OriginProgram;
use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Mustahiq\MustahiqDetail;
use App\Models\Base\Settings\Disability;
use App\Models\Base\Settings\District;
use App\Models\Base\Settings\Occupation;
use App\Models\Base\Settings\Sponsor;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Maatwebsite\Excel\Facades\Excel;

class AllMustahiqController extends Controller
{
    public function index()
    {
        return view('dashboard.base.all-mustahiq.view-mustahiq');
    }

    public function viewAll(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,origin_program,gender,religion,status,earn_ability,training_ability,created_at');
        $data = Mustahiq::with('details:mustahiq_id,is_earn_ability')
            ->select('id', 'created_at', 'name', 'gender', 'religion', 'status', 'origin_program')
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists'          => $data,
            'statuses'       => MustahiqStatus::cases(),
            'genders'        => MustahiqGender::cases(),
            'religions'      => MustahiqReligion::cases(),
            'originPrograms' => OriginProgram::cases(),
        ]);
    }

    public function reportIndex(): Renderable
    {
        return view('dashboard.base.all-mustahiq.report-mustahiq');
    }

    public function reportInitData(): array
    {
        return [
            "districts"       => District::getAll(["id", "name"]),
            "sponsors"        => Sponsor::getAll(['id', 'name as text']),
            "statuses"        => MustahiqStatus::cases(),
            "genders"         => MustahiqGender::cases(),
            "religions"       => MustahiqReligion::cases(),
            "occupations"     => Occupation::getAll(),
            "educationLevels" => MustahiqEducationLevel::cases(),
            "disabilityTypes" => Disability::getAll(),
            "originPrograms"  => OriginProgram::cases(),
        ];
    }

    public function reportDownload(Request $request)
    {
        $disabilityArray = ['all', 'all_not_disable', 'all_disable'];
        $request->validate([
            'report_type'             => ['required', 'in:pdf,xls,view'],
            'program_type'            => ['nullable', new Enum(OriginProgram::class)],
            'status'                  => ['nullable', new Enum(MustahiqStatus::class)],
            'date_from'               => ['nullable', 'date'],
            'date_to'                 => ['nullable', 'date', Rule::requiredIf($request->filled('date_from')), 'after_or_equal:date_from'],
            'gender'                  => ['nullable', new Enum(MustahiqGender::class)],
            'religion'                => ['nullable', new Enum(MustahiqReligion::class)],
            'is_earn_ability'         => ['nullable', 'in:yes,no'],
            'highest_education_level' => ['nullable', new Enum(MustahiqEducationLevel::class)],
            'age_from'                => ['nullable', 'numeric'],
            'age_to'                  => [Rule::when($request->input('age_from'), ['required', 'after_or_equal:age_from'])],
            'district_id'             => ['nullable', Rule::exists(District::getTableName(), 'id')],
            'sponsor_id'              => ['nullable', Rule::exists(Sponsor::getTableName(), 'id')],
            'disability_id'           => ['nullable', Rule::in(array_merge($disabilityArray, Disability::pluck('id')->toArray()))],
            'occupation_id'           => ['nullable', Rule::exists(Occupation::getTableName(), 'id')],
        ]);

        $report_type = $request->input("report_type");
        $program_type = $request->input("program_type");
        $status = $request->input("status");
        $date_from = $request->input("date_from");
        $date_to = $request->input("date_to");
        $gender = $request->input("gender");
        $religion = $request->input("religion");
        $highest_education_level = $request->input("highest_education_level");
        $isEarnAbility = $request->input("is_earn_ability");
        $age_from = $request->input("age_from") ? getAgeToBirthday((int)$request->input("age_from")) : null;
        $age_to = $request->input("age_from") ? getAgeToBirthday((int)$request->input("age_to")) : null;
        $district_id = $request->input("district_id");
        $sponsor_id = $request->input("sponsor_id");
        $sponsor = $sponsor_id ? Sponsor::getRowById($sponsor_id) : null;
        $occupation_id = $request->input("occupation_id");
        $occupation = $occupation_id ? Occupation::getRowById($occupation_id) : null;
        $disability_id = $request->input("disability_id");
        $m = Mustahiq::getTableName();
        $md = MustahiqDetail::getTableName();
        $items = Mustahiq::join($md . " as md", function ($join) use ($m) {
            $join->on('md.mustahiq_id', '=', $m . '.id')->wherenull('md.deleted_at');
        })->when($status, function ($sql) use ($status) {
            $sql->where('status', '=', $status);
        })->when($sponsor_id, function ($sql) use ($sponsor_id) {
            $sql->where('sponsor_id', '=', $sponsor_id);
        })->when($program_type, function ($sql) use ($program_type) {
            $sql->where('origin_program', '=', $program_type);
        })->when($gender, function ($sql) use ($gender) {
            $sql->where('gender', '=', $gender);
        })->when($religion, function ($sql) use ($religion) {
            $sql->where('religion', '=', $religion);
        })->when($disability_id, function ($sql) use ($disability_id) {
            $disability_id == 'all_not_disable' ? $sql->where('is_disability', 0) : ($disability_id == 'all_disable' ? $sql->where('is_disability', 1) : $sql->where('disability_id', '=', $disability_id));
        })->when($district_id, function ($sql) use ($district_id) {
            $sql->where('permanent_district_id', '=', $district_id);
        })->when($date_from && $date_to, function ($sql) use ($m, $date_from, $date_to) {
            $sql->whereBetween($m . '.created_at', [$date_from, $date_to]);
        })->when($age_from && $age_to, function ($sql) use ($age_from, $age_to) {
            $sql->whereBetween('birth_date', [$age_to, $age_from]);
        })->when($occupation_id, function ($sql) use ($occupation_id) {
            $sql->where('occupation_id', '=', $occupation_id);
        })->when($highest_education_level, function ($sql) use ($highest_education_level) {
            $sql->where('highest_education_level', '=', $highest_education_level);
        })->when($isEarnAbility, function ($sql) use ($isEarnAbility) {
            $isEarnAbility == 'yes' ? $sql->where('is_earn_ability', 1) : $sql->where('is_earn_ability', 0);
        })->get();

        $data = [
            'mustahiq'   => $items,
            'program'    => $program_type ?? 'All',
            'sponsor'    => $sponsor ? $sponsor->name : 'All',
            'status'     => $status ?? 'All',
            'age_range'  => ($age_from && $age_to) ? Carbon::parse($age_from)->age . ' - ' . Carbon::parse($age_to)->age : 'All',
            'date_range' => ($date_from && $date_to) ? Carbon::parse($date_from)->format('d M Y') . ' - ' . Carbon::parse($date_to)->format('d M Y') : 'All',
        ];

        if ($report_type == 'pdf') {
            $file_name = 'Report_all_mustahiq_list_' . Carbon::now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.download.pdf.mustahiq_list', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ($report_type == 'xls') {
            $file_name = 'Report_all_mustahiq_list_' . Carbon::now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.download.pdf.mustahiq_list', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ($report_type == 'view') {
            return view('dashboard.download.pdf.mustahiq_list', compact('data'));
        }
    }
}
