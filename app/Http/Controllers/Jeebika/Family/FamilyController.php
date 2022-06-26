<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Enums\FamilyStatus;
use App\Enums\JGroStatus;
use App\Enums\JTrainingMethod;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class FamilyController extends Controller
{
    public function index(): Renderable
    {
        $view = session('s_j_project_id') ? 'dashboard.jeebika.family.family-project-manager-view' : 'dashboard.jeebika.family.family-admin-view';
        return view($view);
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,status,need_assessment,created_at');
        $request->validate([
            "select_p" => ['nullable', 'numeric', Rule::exists(JProject::class, 'id')],
            "select_g" => ['nullable', 'numeric', Rule::exists(JGro::class, 'id')],
        ]);
        $projectId = $request->input("select_p") ?? null;
        $groId = $request->input("select_g") ?? null;
        $allGROs = [];
        $jeebika = Jeebika::select('j_project_id', 'j_gro_id', 'family_id');
        if (session('s_j_project_id')) {
            $jeebika = $jeebika->where('j_project_id', session('s_j_project_id'));
            $allGROs = JGro::select('id', 'name', 'j_project_id')->where('j_project_id', session('s_j_project_id'))->get();
            if ($groId) {
                $jeebika = $jeebika->where('j_gro_id', $groId);
            }
        } else {
            if ($projectId) {
                $jeebika = $jeebika->where('j_project_id', $projectId);
                $allGROs = JGro::select('id', 'name', 'j_project_id')->where('j_project_id', $projectId)->get();
            }
            if ($groId) {
                $jeebika = $jeebika->where('j_project_id', $projectId)->where('j_gro_id', $groId);
            }
        }
        $families = Family::with(['jeebika.j_project:id,name', 'jeebika.j_gro:id,name', 'familyBalance'])->select('id', 'name', 'number_of_family_member', 'need_assessment', 'status', 'created_at')
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%');
            })
            ->whereIn('id', $jeebika->pluck('family_id'))
            ->where('status', FamilyStatus::Active)
            ->orderBy($sort, $type)->paginate($item);
        $data = ['lists' => $families, 'allGROs' => $allGROs, 'statuses' => FamilyStatus::cases()];
        $finalData = session('s_j_project_id') ? $data : array_merge($data, ['allProjects' => JProject::select('id', 'name', 'status')
            ->where('status', JGroStatus::Active)->get()]);
        return response()->json($finalData, Response::HTTP_OK);
    }

    public function viewById($id): Renderable
    {
        $family = Family::findOrFail($id);
        $jeebika = Jeebika::with(['j_project:id,name', 'j_gro:id,name'])->where('family_id', $family->id)->first();
        return view('dashboard.jeebika.family.view', compact('family', 'jeebika'));
    }
}


