<?php

namespace App\Http\Controllers\Jeebika\HealthSession;

use App\Enums\JHealthSessionStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyMember;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\HealthSession\JHealthSession;
use App\Models\Jeebika\HealthSession\JHealthSessionParticipant;
use App\Models\Jeebika\Jeebika;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class JHealthSessionParticipantController extends Controller
{
    public function index(Request $request, $hsid): Renderable
    {
        $data = JHealthSession::findOrFail($hsid);

        return view('dashboard.jeebika.health-session.participant', compact('data'));
    }

    public function create(Request $request, $hsid): JsonResponse
    {
        $request->validate([
            'participantIds' => ['required', 'array', Rule::exists(Mustahiq::getTableName(), 'id')],
            'created_by'     => ['required']
        ]);
        $healthSession = JHealthSession::findOrFail($hsid);
        if ($healthSession->status === JHealthSessionStatus::Upcoming && (!empty($request->participantIds) && count($request->participantIds) > 0)) {
            foreach ($request->participantIds as $participant_id) {
                $healthSession->mustahiqs()->attach($participant_id, ['created_by' => $request->created_by]);
            }
            return response()->json(['success' => 'Participant has been successfully added.'], Response::HTTP_OK);
        }
        if ($healthSession->status !== JHealthSessionStatus::Upcoming) {
            return response()->json(['message' => 'Only upcoming health session participant can be added.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => 'Participant has been successfully added.'], Response::HTTP_OK);
    }

    /*Health Session Participant List*/
    public function getList(Request $request, $hsid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'mustahiq_id,created_at,status,is_present', '100,200');


        $data = JHealthSessionParticipant::with(['mustahiq:id,name,mobile'])
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

    /*All pariticipant list projectwise */
    public function allParticipantList(Request $request, $hsid): JsonResponse
    {
        $healthSession = JHealthSession::select('session_heading', 'j_project_id', 'session_method')->where('id', $hsid)
            ->first();
        $familyIds = Jeebika::with(['jProject:id,name', 'family.members_info'])
            ->where('j_project_id', $healthSession->j_project_id)
            ->pluck('family_id');
        $participants = JHealthSessionParticipant::select('id', 'mustahiq_id', 'j_health_session_id')
            ->where('j_health_session_id', $hsid)
            ->pluck('mustahiq_id');


        list($sort, $type, $query, $item) = getListValidation($request, 'mustahiq_id,created_at,status', '100,200');

        $projectParticipants = FamilyMember::with(['mustahiq',
            'jeebika' => function ($builder) {
                $builder->with('j_gro:id,name');
            }, 'family'])
            ->when($query, function ($sql) use ($query) {
                $sql->whereHas('mustahiq', function ($builder) use ($query) {
                    $builder->select('id', 'name')->where('name', 'LIKE', '%' . $query . '%');
                });
            })
            ->whereNotIn('mustahiq_id', $participants)
            ->select('id', 'mustahiq_id', 'family_id')
            ->whereIn('family_id', $familyIds)
            ->orderBy($sort, $type)->paginate($item);


        return response()->json([
            'lists' => removeEmptyKey($projectParticipants)
        ], Response::HTTP_OK);
    }

    public function getElementById($hsid, $id)
    {
        $data = JHealthSession::with([
            'j_project:id,name as text',
        ])
            ->select(JHealthSession::Listkey())
            ->findOrFail($id);

        return response()->json($data, Response::HTTP_OK);
    }

    public function viewById($hsid)
    {
        $data = JHealthSession::findOrFail($hsid);
        return view('dashboard.jeebika.health-session.view', compact('data'));
    }

    public function delete($hsid, $id)
    {
        $item = JHealthSessionParticipant::findOrFail($id);
        $healthSession = JHealthSession::findOrFail($hsid);

        try {
            if ($healthSession->status === JHealthSessionStatus::Upcoming) {
                $item->forceDelete();
            } else
                return response()->json([
                    'message' => 'Only upcoming health session participant can remove',
                ], 422);
        } catch (\Exception $e) {
            if (!$item->delete()) {
                return response()->json([
                    'message' => 'Participant in used',
                ], 422);
            }
        }
        return response()->json([
            'success' => 'Participant has been successfully deleted',
        ], Response::HTTP_OK);
    }

}
