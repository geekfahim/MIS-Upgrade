<?php

namespace App\Http\Controllers\Jeebika\Training;

use App\Enums\JTrainingStatus;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\Training\JTraining;
use App\Models\Jeebika\Training\JTrainingFeedback;
use App\Models\Jeebika\Training\JTrainingMustahiq;
use App\Rules\Remarks;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class JTrainingFeedbackController extends Controller
{
    public function index(Request $request, $tid): Renderable
    {
        $data = JTraining::with(['vocational:id,name', 'skill:id,name'])->findOrFail($tid);
        return view('dashboard.jeebika.training.feedback', compact('data'));
    }

    public function create(Request $request, $tid): JsonResponse
    {
        $request->validate([
            'flag'             => ['required', 'in:yes,no'],
            'participantIds'   => ['required', 'array'],
            'participantIds.*' => [Rule::exists(JTrainingMustahiq::getTableName(), 'mustahiq_id')],
            'remarks'          => ['nullable', 'string', new Remarks(), 'max:999']
        ]);

        $participants = $request->participantIds;
        $training = JTraining::findOrFail($tid);
        $count = count($participants);
        if ($training->status !== JTrainingStatus::Complete) {
            return response()->json(['message' => 'Only complete training\'s feedback is possible '], Response::HTTP_OK);
        }
        if (!empty($participants) && $count > 0) {
            foreach ($participants as $participant) {
                $data = JTrainingFeedback::create([
                    'mustahiq_id'           => $participant,
                    'j_training_id'         => $tid,
                    'is_training_real_life' => 1 ? $request->flag === 'yes' : 0,
                    'created_by'            => $request->created_by,
                    'remarks'               => $request->remarks,
                    'created_at'            => now(),
                ]);
            }
        }


        return response()->json(['success' => 'Participant\'s feedback has been successfully created.'], Response::HTTP_OK);
    }

    public function getList(Request $request, $tid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'mustahiq_id,created_at,status,is_training_real_life');

        $data = JTrainingFeedback::with(['training', 'mustahiq'])
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

    /*All participant list training-wise */
    public function allParticipantList(Request $request, $tid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'mustahiq_id,created_at,status');

        $training = JTraining::findOrFail($tid);
        $data = JTrainingMustahiq::with(['mustahiq:id,name,mobile'])
            ->when($query, function ($sql) use ($query) {
                $sql->whereHas('mustahiq', function ($builder) use ($query) {
                    $builder->select('id', 'name')->where('name', 'LIKE', '%' . $query . '%');
                });
            })
            ->where('j_training_id', $tid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists'          => $data,
            'trainingStatus' => $training->status
        ], Response::HTTP_OK);
    }
}
