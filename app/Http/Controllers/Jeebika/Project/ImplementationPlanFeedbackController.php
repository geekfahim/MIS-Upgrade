<?php

namespace App\Http\Controllers\Jeebika\Project;

use App\Enums\JImplementationPlanStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Acl\User;
use App\Models\Base\Family\Family;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JImplementationPlan;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Settings\JIndicator;
use App\Rules\Remarks;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ImplementationPlanFeedbackController extends Controller
{
    public function index($pid): Renderable
    {
        $project = JProject::find($pid);
        return view('dashboard.jeebika.project.implementation-plan-feedback', compact('project'));
    }

    public function getList(Request $request, $pid): JsonResponse
    {
        $request->validate([
            "page" => 'nullable|numeric|digits_between:1,10',
            "sort" => 'nullable|in:possible_implementation_date,gro_name,family_name,member_name,indicator_name',
            "type" => 'nullable|in:asc,desc',
            "query" => 'nullable|string|max:50',
            "item" => 'nullable|in:25,50,100,200',
            "from_date" => Rule::when($request->filled('to_date'), ['required', 'date', 'max:10', 'before_or_equal:to_date']),
            "to_date" => Rule::when($request->filled('from_date'), ['required', 'date', 'max:10', 'after_or_equal:from_date'])
        ]);
        $sort = $request->input("sort") ?? 'created_at';
        $type = $request->input("type") ?? "asc";
        $query = $request->input("query");
        $item = $request->input("item") ?? 50;
        $from_date = $request->input("from_date") ?? now()->startOfMonth();
        $to_date = $request->input("to_date") ?? now()->endOfMonth();

        $i = JIndicator::getTableName();
        $m = Mustahiq::getTableName();
        $f = Family::getTableName();
        $g = JGro::getTableName();
        $u = User::getTableName();
        $jip = JImplementationPlan::getTableName();

        $data = JImplementationPlan::join($i . ' as indicator', 'indicator.id', '=', 'j_indicator_id')
            ->join($f . ' as family', 'family.id', '=', 'family_id')
            ->join($g . ' as gro', 'gro.id', '=', 'j_gro_id')
            ->leftJoin($m . ' as member', function ($join) {
                $join->on('member.id', '=', 'member_id');
            })
            ->leftJoin($u . ' as implemented_by', function ($join) {
                $join->on('implemented_by.id', '=', 'implemented_by');
            })
            ->select([
                $jip . '.id as id',
                $jip . '.created_at as created_at',
                'j_gro_id',
                'j_indicator_id',
                'family_id',
                'member_id',
                'implement_status as status',
                'possible_implementation_date',
                'implemented_date',
                'implemented_by',
                'implement_status',
                'indicator.name as indicator_name',
                'member.name as member_name',
                'family.name as family_name',
                'gro.name as gro_name',
                'implemented_by.name as implemented_by_name',
            ])
            ->where($jip . '.j_project_id', $pid)
            ->whereBetween('possible_implementation_date', [$from_date, $to_date])
            ->when($query, function ($sql) use ($query) {
                $sql->where('gro.name', 'LIKE', '%' . $query . '%')
                    ->orWhere('family.name', 'LIKE', '%' . $query . '%')
                    ->orWhere('indicator.name', 'LIKE', '%' . $query . '%')
                    ->orWhere('member.name', 'LIKE', '%' . $query . '%');
            })
            ->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists' => $data,
            'statuses' => JImplementationPlanStatus::cases()
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $pid, $id): JsonResponse
    {
        $request->validate([
            'status' => [new Enum(JImplementationPlanStatus::class)],
            'date' => [Rule::requiredIf(JImplementationPlanStatus::Implemented->value === $request->status), 'date'],
            'remarks' => [Rule::requiredIf(JImplementationPlanStatus::Rejected->value === $request->status), new Remarks(), 'max:999']
        ]);
        $data = JImplementationPlan::findOrFail($id);
        if (JImplementationPlanStatus::Pending !== $data->implement_status) {
            return response()->json(['message' => "Only pending implementation plan can be {$request->status}"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (JImplementationPlanStatus::Pending === $request->status) {
            return response()->json(['warning' => "This implementation plan already in {$request->status}"], Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }
        $data->implement_status = $request->status;
        $data->implemented_by = auth()->id();
        if (JImplementationPlanStatus::Implemented === $request->status) {
            $data->implemented_date = $request->date;
            $data->remarks = $request->remarks ?? null;
        }
        $data->save();
        return response()->json(['success' => "Implementation plan has been successfully {$request->status}."], Response::HTTP_OK);
    }
}
