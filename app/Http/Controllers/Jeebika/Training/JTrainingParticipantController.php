<?php

namespace App\Http\Controllers\Jeebika\Training;

use App\Enums\JTrainingStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyMember;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\Training\JTraining;
use App\Models\Jeebika\Training\JTrainingMustahiq;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class JTrainingParticipantController extends Controller
{
    public function index(Request $request, $tid): Renderable
    {
        $data = JTraining::with(['vocational:id,name', 'skill:id,name'])->findOrFail($tid);

        return view('dashboard.jeebika.training.participant', compact('data'));
    }

    public function create(Request $request, $tid): JsonResponse
    {
        $request->validate([
            'participantIds' => ['required', 'array', Rule::exists(Mustahiq::getTableName(), 'id')],
            'created_by'     => ['required']
        ]);
        $training = JTraining::findOrFail($tid);
        if ($training->status === JTrainingStatus::Upcoming && (!empty($request->participantIds) && count($request->participantIds) > 0)) {
            foreach ($request->participantIds as $participant_id) {
                $training->mustahiqs()->attach($participant_id, ['created_by' => $request->created_by]);
            }
        }
        if ($training->status !== JTrainingStatus::Upcoming) {
            return response()->json(['message' => 'Only upcoming training participant can be added.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => 'Participant has been successfully added.'], Response::HTTP_OK);
    }

    /*Training Participant List*/
    public function getList(Request $request, $tid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'mustahiq_id,created_at,status,is_present', '100,200');
        $data = JTrainingMustahiq::with(['mustahiq:id,name,mobile'])
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

    /*All pariticipant list projectwise */
    public function allParticipantList(Request $request, $tid): JsonResponse
    {
        $training = JTraining::select('training_heading', 'j_project_id', 'training_type')->where('id', $tid)
            ->first();
        $familyIds = Jeebika::with(['jProject:id,name', 'family.members_info'])
            ->where('j_project_id', $training->j_project_id)
            ->pluck('family_id');

        $participants = JTrainingMustahiq::select('id', 'mustahiq_id', 'j_training_id')
            ->where('j_training_id', $tid)
            ->pluck('mustahiq_id');


        list($sort, $type, $query, $item) = getListValidation($request, 'mustahiq_id,created_at,status', '100,200');

        $projectParticipants = FamilyMember::with(['mustahiq' => function ($builder) use ($training) {
            $builder->select('id', 'name', 'mobile')
                ->when($training->training_type === 'Vocational', function ($q) {
                    $q->with(['vocational_needs.vocational:id,name', 'vocational_haves.vocational:id,name']);
                })
                ->when($training->training_type === 'Skill', function ($q) {
                    $q->with(['skill_needs.skill:id,name', 'skill_haves.skill:id,name']);
                });
        },
                                                   'jeebika'  => function ($builder) {
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

    public function getElementById($tid, $id)
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

    public function viewById($tid)
    {
        $data = JTraining::findOrFail($tid);
        return view('dashboard.jeebika.training.view', compact('data'));
    }

    public function delete($tid, $id)
    {
        $item = JTrainingMustahiq::findOrFail($id);
        $training = JTraining::findOrFail($tid);

        try {
            if ($training->status === JTrainingStatus::Upcoming) {
                $item->forceDelete();
            } else
                return response()->json([
                    'message' => 'Only upcoming training participant can remove',
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
