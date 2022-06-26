<?php

namespace App\Http\Controllers\Jeebika\HealthSession;

use App\Enums\JHealthSessionStatus;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\HealthSession\JHealthSession;
use App\Models\Jeebika\HealthSession\JHealthSessionFeedback;
use App\Models\Jeebika\HealthSession\JHealthSessionParticipant;
use App\Rules\Remarks;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class JHealthSessionFeedbackController extends Controller
{
    public function index(Request $request, $hsid): Renderable
    {
        $data = JHealthSession::findOrFail($hsid);
        return view('dashboard.jeebika.health-session.feedback', compact('data'));
    }

    public function create(Request $request, $hsid): JsonResponse
    {
        $request->validate([
            'flag'             => ['required', 'in:yes,no'],
            'participantIds'   => ['required', 'array'],
            'participantIds.*' => [Rule::exists(JHealthSessionParticipant::getTableName(), 'mustahiq_id')],
            'remarks'          => ['nullable', 'string', new Remarks(), 'max:999']
        ]);

        $participants = $request->participantIds;
        $healthSession = JHealthSession::findOrFail($hsid);
        $count = count($participants);
        if ($healthSession->status !== JHealthSessionStatus::Complete) {
            return response()->json(['message' => 'Only complete health session\'s feedback is possible '], Response::HTTP_OK);
        }
        if (!empty($participants) && $count > 0) {
            foreach ($participants as $participant) {
                $data = JHealthSessionFeedback::create([
                    'mustahiq_id'         => $participant,
                    'j_health_session_id' => $hsid,
                    'created_by'          => $request->created_by,
                    'remarks'             => $request->remarks,
                    'created_at'          => now(),
                ]);
            }
        }


        return response()->json(['success' => 'Participant\'s feedback has been successfully created.'], Response::HTTP_OK);
    }

    public function getList(Request $request, $hsid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'mustahiq_id,created_at,status');

        $data = JHealthSessionFeedback::with(['health_session', 'mustahiq'])
            ->when($query, function ($sql) use ($query) {
                $sql->whereHas('mustahiq', function ($builder) use ($query) {
                    $builder->select('id', 'name')->where('name', 'LIKE', '%' . $query . '%');
                });
            })
            ->where('j_health_session_id', $hsid)
            ->orderBy($sort, $type)->paginate($item);

        $healthSession = JHealthSession::findOrFail($hsid);

        return response()->json([
            'lists'               => $data,
            'healthSessionStatus' => $healthSession->status
        ], Response::HTTP_OK);
    }

    /*All participant list healthSession-wise */
    public function allParticipantList(Request $request, $hsid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'mustahiq_id,created_at,status');

        $healthSession = JHealthSession::findOrFail($hsid);
        $data = JHealthSessionParticipant::with(['mustahiq:id,name,mobile'])
            ->when($query, function ($sql) use ($query) {
                $sql->whereHas('mustahiq', function ($builder) use ($query) {
                    $builder->select('id', 'name')->where('name', 'LIKE', '%' . $query . '%');
                });
            })
            ->where('j_health_session_id', $hsid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists'               => $data,
            'healthSessionStatus' => $healthSession->status
        ], Response::HTTP_OK);
    }
}
