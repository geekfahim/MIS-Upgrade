<?php

namespace App\Http\Controllers\Jeebika\Training;

use App\Enums\JTrainingStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Settings\Skill;
use App\Models\Base\Settings\Vocational;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Training\JTraining;
use App\Models\Jeebika\Validators\JTrainingValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JTrainingController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.jeebika.training.training');
    }

    public function create(Request $request): JsonResponse
    {
        $attributes = (new JTrainingValidator())->validate($data = new JTraining(), $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Training has been successfully created.'], Response::HTTP_OK);
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'training_heading,created_at,status');
        $data = JTraining::with(['j_project:id,name', 'vocational:id,name', 'skill:id,name'])
            ->when($query, function ($sql) use ($query) {
                $sql->where('training_heading', 'LIKE', '%' . $query . '%');
            })
            ->when(session('s_j_project_id'), function ($builder) {
                $builder->where('j_project_id', session('s_j_project_id'));
            })
            ->orderBy($sort, $type)->paginate($item);

        $updateStatuses = [JTrainingStatus::Upcoming, JTrainingStatus::Postponed, JTrainingStatus::Rejected];
        $vocationals = Vocational::select(['id', 'name'])->get();
        $skills = Skill::select(['id', 'name'])->get();

        return response()->json([
            'lists'          => $data,
            'projects'       => JProject::select(['id', 'name'])->get(),
            'vocationals'    => $vocationals,
            'skills'         => $skills,
            'statuses'       => JTrainingStatus::cases(),
            'updateStatuses' => $updateStatuses,
        ], Response::HTTP_OK);
    }

    public function getElementById($id)
    {
        $data = JTraining::with([
            'j_project:id,name as text',
            'vocational:id,name',
            'skill:id,name'
        ])
            ->select(JTraining::Listkey())
            ->findOrFail($id);
        return response()->json($data, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $data = JTraining::findOrFail($id);
        $attributes = (new JTrainingValidator())->validate($data, $request->all());
        if ($data->status === JTrainingStatus::Upcoming || $data->status === JTrainingStatus::Postponed) {
            $data->fill($attributes)->save();
        } else
            return response()->json([
                'message' => "Only upcoming and postponed training can edit",
            ], 422);
        return response()->json([
            'success' => 'Training has been successfully updated.',
        ], Response::HTTP_OK);
    }

    public function delete($id)
    {
        $item = JTraining::findOrFail($id);

        try {
            if ($item->status === JTrainingStatus::Upcoming) {
                $item->forceDelete();
            } else
                return response()->json([
                    'message' => "Only Upcoming Training Can Delete !",
                ], 422);

        } catch (Exception $e) {
            if (!$item->delete()) {
                return response()->json([
                    'message' => $item->training_heading . ' in used',
                ], 422);
            }
        }
        return response()->json([
            'success' => $item->training_heading . ' has been successfully deleted',
        ], Response::HTTP_OK);
    }

}
