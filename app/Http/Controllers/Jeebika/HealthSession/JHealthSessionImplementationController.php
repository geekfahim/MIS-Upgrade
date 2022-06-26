<?php

namespace App\Http\Controllers\Jeebika\HealthSession;

use App\Enums\JHealthSessionStatus;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\HealthSession\JHealthSession;
use App\Models\Jeebika\HealthSession\JHealthSessionParticipant;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class JHealthSessionImplementationController extends Controller
{
    public function index($hsid): Renderable
    {
        $data = JHealthSession::findOrFail($hsid);
        return view('dashboard.jeebika.health-session.implementation', compact('data'));
    }

    public function getList(Request $request, $hsid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'mustahiq_id,created_at,status');
        $data = JHealthSessionParticipant::with(['mustahiq:id,name,email,mobile,reference_number'])
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

    public function update(Request $request, $hsid)
    {

        $request->validate([
            'flag'             => ['required', Rule::in(['Present', 'Absent', 'Complete'])],
            'participantIds'   => ['required_if:flag,Present,Absent', 'array'],
            'participantIds.*' => ['required_if:flag,Present,Absent', Rule::exists(JHealthSessionParticipant::getTableName(), 'id')]
        ]);
        $healthSession = JHealthSession::with('mustahiqs')->findOrFail($hsid);
        $participant = JHealthSessionParticipant::where('j_health_session_id', $hsid)->pluck('mustahiq_id');

        if ($healthSession->status !== JHealthSessionStatus::Upcoming) {
            return response()->json(['message' => 'Only upcoming health session can be updated.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (count($participant) === 0) {
            return response()->json(['message' => 'No participants found. Please add participants first.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //complete
        if ($request->flag === JHealthSessionStatus::Complete->value) {
            $healthSession->status = JHealthSessionStatus::Complete;
            $healthSession->update();
            return response()->json([
                'success' => 'Health Session has been completed',
            ], Response::HTTP_OK);

        }
        //absent && preset
        $participantIds = $request->participantIds;
        if ($request->flag !== JHealthSessionStatus::Complete && (!empty($participantIds) && count($participantIds) > 0)) {
            foreach ($participantIds as $participantId) {
                $data = JHealthSessionParticipant::find($participantId);
                $data->is_present = $request->flag === 'Present';
                $data->save();
            }
            return response()->json([
                'success' => 'Health Session participants attendance status updated',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => 'Implementation has been successful',
        ], Response::HTTP_OK);
    }

}
