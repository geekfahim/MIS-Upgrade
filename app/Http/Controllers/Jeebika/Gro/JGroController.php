<?php

namespace App\Http\Controllers\Jeebika\Gro;

use App\Enums\OriginProgram;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Validators\JGroValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class JGroController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $view = session('s_j_project_id') ? 'dashboard.jeebika.gro.gro-project-manager-view' : 'dashboard.jeebika.gro.gro-admin-view';
        return view($view, ['programName' => OriginProgram::JEEBIKA->value]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request);
        $request->validate([
            "select" => ['nullable', 'numeric', Rule::exists(JProject::class, 'id')],
        ]);
        $projectSelected = $request->input("select") ?? '';
        $data = JGro::select(JGro::getColumns())
            ->with('j_project:id,name')
            ->withCount('families')
            ->when($query, function ($builder) use ($query) {
                $builder->where('name', 'LIKE', '%' . $query . '%');
            })
            ->when($projectId = session('s_j_project_id'), function ($builder) use ($projectId) {
                $builder->where('j_project_id', $projectId);
            })
            ->when($projectSelected, function ($builder) use ($projectSelected) {
                $builder->where('j_project_id', $projectSelected);
            })
            ->orderBy($sort, $type)->paginate($item);
        $projects = $projectId ? [] : ['allProjects' => JProject::getAll(['id', 'name'])];
        $mergedData = array_merge(['lists' => $data,], $projects);
        return response()->json($mergedData, Response::HTTP_OK);
    }

    public function viewById($id)
    {
        $gro = JGro::findOrFail($id);
        return view('dashboard.jeebika.gro.view', compact('gro'));
    }

    /**
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        $attributes = (new JGroValidator())->validate($JGro = new JGro(), request()->all());
        $attributes['created_by'] = request('created_by');
        $JGro->fill($attributes)->save();
        return response()->json(['success' => $JGro->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getElementById($id): JsonResponse
    {
        $data = JGro::with([
            'j_project:id,name as text',
            'leader:id,name as text,mobile',
            'cashier:id,name as text,mobile',
            'bank:id,name as text',
            'created_user:id,name',
            'updated_user:id,name'
        ])->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function update($id): JsonResponse
    {
        $data = JGro::findOrFail($id);
        $attributes = (new JGroValidator())->validate($data, request()->all());
        $attributes['updated_by'] = request('updated_by');
        $data->fill($attributes);
        if ($data->isDirty('j_project_id')) {
            $data->fill(['j_project_name' => JProject::find($data->j_project_id)->name]);
        }
        $data->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.',], Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $data = JGro::findOrFail($id);
        if (Jeebika::firstWhere('j_gro_id', $data->id)) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $data->forceDelete();
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }
}
