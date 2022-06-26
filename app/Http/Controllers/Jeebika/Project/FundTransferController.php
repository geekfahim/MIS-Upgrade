<?php

namespace App\Http\Controllers\Jeebika\Project;

use App\Http\Controllers\Controller;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Project\JProjectFundTransfer;
use App\Rules\Name;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FundTransferController extends Controller
{

    public function index($pid): Renderable
    {
        $project = JProject::find($pid);
        return view('dashboard.jeebika.project.fund-transfer', compact('project'));
    }

    public function getList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'date,amount,created_at');
        $items = JProjectFundTransfer::select(JProjectFundTransfer::getColumns())
            ->when($query, function ($sql) use ($query) {
                $sql->where('date', 'LIKE', '%' . $query . '%')
                    ->orWhere('amount', 'LIKE', '%' . $query . '%')
                    ->orWhere('remarks', 'LIKE', '%' . $query . '%');
            })
            ->where('j_project_id', $pid)
            ->orderBy($sort, $type)->paginate($item);
        return response()->json($items, Response::HTTP_OK);
    }

    public function create(Request $request, $pid): JsonResponse
    {
        $request->validate([
            'date'    => ['required', 'date'],
            'amount'  => ['required', 'numeric', 'digits_between:0,10'],
            'remarks' => ['nullable', new Name(), 'max:998']
        ]);
        $project = JProject::findOrFail($pid);
        JProjectFundTransfer::create([
            'j_project_id' => $project->id,
            'date'         => $request->input('date'),
            'amount'       => $request->input('amount'),
            'remarks'      => $request->input('remarks'),
            'created_by'   => $request->input('created_by'),
        ]);
        return response()->json([
            'success' => 'Fund transfer has been successfully created.',
        ], Response::HTTP_OK);
    }

    public function getElementById($pid, $id): JsonResponse
    {
        $item = JProjectFundTransfer::with(['created_user:id,name', 'updated_user:id,name'])->select(JProjectFundTransfer::getColumns())->findOrFail($id);
        return response()->json($item, Response::HTTP_OK);
    }

    public function update(Request $request, $pid, $id): JsonResponse
    {
        $request->validate([
            'date'    => ['required', 'date'],
            'amount'  => ['required', 'numeric', 'digits_between:0,10'],
            'remarks' => ['nullable', 'max:998'],
        ]);
        $item = JProjectFundTransfer::findOrFail($id);
        $item->date = $request->input('date');
        $item->amount = $request->input('amount');
        $item->remarks = $request->input('remarks');
        $item->updated_by = $request->input('updated_by');
        $item->save();

        return response()->json([
            'success' => 'Fund transfer has been successfully updated.',
        ], Response::HTTP_OK);
    }

    public function delete($pid, $id): JsonResponse
    {
        $item = JProjectFundTransfer::findOrFail($id);
        if (!$item->delete()) {
            return response()->json([
                'message' => $item->name . ' in used',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json([
            'success' => 'Fund transfer has been successfully deleted',
        ], Response::HTTP_OK);
    }
}
