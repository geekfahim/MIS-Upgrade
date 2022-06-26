<?php

namespace App\Http\Controllers\Jeebika\HealthSession;

use App\Enums\JHealthSessionStatus;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\HealthSession\JHealthSession;
use App\Models\Jeebika\Validators\JHealthSessionValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JHealthSessionController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.jeebika.health-session.health-session');
    }

    public function create(Request $request): JsonResponse
    {
        $attributes = (new JHealthSessionValidator())->validate($data = new JHealthSession(), $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Health Session has been successfully created.'], Response::HTTP_OK);
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'session_heading,created_at,status');
        $data = JHealthSession::with('j_project:id,name')
            ->when($query, function ($sql) use ($query) {
                $sql->where('session_heading', 'LIKE', '%' . $query . '%');
            })
            ->when(session('s_j_project_id'), function ($builder) {
                $builder->where('j_project_id', session('s_j_project_id'));
            })
            ->orderBy($sort, $type)->paginate($item);

        $updateStatuses = [JHealthSessionStatus::Upcoming, JHealthSessionStatus::Postponed, JHealthSessionStatus::Rejected];
        return response()->json([
            'lists' => $data,
            'statuses' => JHealthSessionStatus::cases(),
            'updateStatuses' => $updateStatuses,
        ], Response::HTTP_OK);
    }

    public function getElementById($id)
    {
        $data = JHealthSession::with('j_project:id,name as text')->select(JHealthSession::Listkey())->findOrFail($id);
        return response()->json($data, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $data = JHealthSession::findOrFail($id);
        $attributes = (new JHealthSessionValidator())->validate($data, $request->all());
        if ($data->status === JHealthSessionStatus::Upcoming || $data->status === JHealthSessionStatus::Postponed) {
            $data->fill($attributes)->save();
        } else
            return response()->json(['message' => "Only upcoming and postponed session can edit"], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'Health session has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id)
    {
        $item = JHealthSession::findOrFail($id);
        try {
            if ($item->status === JHealthSessionStatus::Upcoming) {
                $item->forceDelete();
            } else
                return response()->json(['message' => "Only upcoming health session can delete!"], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (Exception $e) {
            if (!$item->delete()) {
                return response()->json(['message' => $item->session_heading . ' in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        return response()->json(['success' => $item->session_heading . ' has been successfully deleted'], Response::HTTP_OK);
    }
}
