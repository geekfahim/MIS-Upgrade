<?php

namespace App\Http\Controllers\Jeebika\Training;

use App\Enums\JTrainingStatus;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\Training\JTraining;
use App\Models\Jeebika\Training\JTrainingMustahiq;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class JTrainingImplementationController extends Controller
{
    public function index(Request $request, $tid): Renderable
    {
        $data = JTraining::with(['vocational:id,name', 'skill:id,name'])->findOrFail($tid);
        return view('dashboard.jeebika.training.implementation', compact('data'));
    }

    public function getList(Request $request, $tid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'mustahiq_id,created_at,status');
        $data = JTrainingMustahiq::with(['mustahiq:id,name,email,mobile,reference_number'])
            ->when($query, function ($sql) use ($query) {
                $sql->whereHas('mustahiq', function ($builder) use ($query) {
                    $builder->select('id', 'name')->where('name', 'LIKE', '%' . $query . '%');
                });
            })
            ->where('j_training_id', $tid)
            ->orderBy($sort, $type)->paginate($item);

        $training = JTraining::findOrFail($tid);

        return response()->json([
            'lists'          => $data,
            'trainingStatus' => $training->status
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $tid)
    {

        $request->validate([
            'flag'             => ['required', Rule::in(['Present', 'Absent', 'Complete'])],
            'participantIds'   => ['required_if:flag,Present,Absent', 'array'],
            'participantIds.*' => ['required_if:flag,Present,Absent', Rule::exists(JTrainingMustahiq::getTableName(), 'id')]
        ]);
        $training = JTraining::with('mustahiqs')->findOrFail($tid);
        $participant = JTrainingMustahiq::where('j_training_id', $tid)->pluck('mustahiq_id');

        if ($training->status !== JTrainingStatus::Upcoming) {
            return response()->json(['message' => 'Only upcoming training can be updated.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (count($participant) === 0) {
            return response()->json(['message' => 'No participants found. Please add participants first.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //complete
        if ($request->flag === JTrainingStatus::Complete->value) {
            $training->status = JTrainingStatus::Complete;
            $training->update();
            return response()->json([
                'success' => 'Training has been completed',
            ], Response::HTTP_OK);

        }
        //absent && preset
        $participantIds = $request->participantIds;
        if ($request->flag !== JTrainingStatus::Complete && (!empty($participantIds) && count($participantIds) > 0)) {
            foreach ($participantIds as $participantId) {
                $data = JTrainingMustahiq::find($participantId);
                $data->is_present = $request->flag === 'Present';
                $data->save();
            }
            return response()->json([
                'success' => 'Training participants attendance status updated',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => 'Implementation has been successful',
        ], Response::HTTP_OK);
    }

}
