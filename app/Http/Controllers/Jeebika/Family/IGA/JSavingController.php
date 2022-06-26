<?php

namespace App\Http\Controllers\Jeebika\Family\IGA;

use App\Enums\IGA\JSavingStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\IGA\JSaving;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Models\Jeebika\Validators\JSavingsValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JSavingController extends Controller
{
    public function index($fid): Renderable
    {
        $family = Family::findOrFail($fid);
        return view('dashboard.jeebika.family.IGA.savings', compact('family'));
    }

    public function getList(Request $request, $fid): JsonResponse
    {
        $projectId = Jeebika::firstWhere('family_id', $fid);
        list($sort, $type, $query, $item) = getListValidation($request, 'date,confirmed_amount,approved_amount,status,created_at');
        $data = JSaving::with('collector:id,name')->select(JSaving::listKey())
            ->when($query, function ($sql) use ($query) {
                $sql->where('confirmed_amount', 'LIKE', '%' . $query . '%')
                    ->orWhereHas('collector', function ($builder) use ($query) {
                        $builder->select('id', 'name')->where('name', 'LIKE', '%' . $query . '%');
                    });
            })
            ->where('family_id', $fid)->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists' => $data,
            'fieldOfficers' => JProjectFieldOfficer::getOfficersByProjectId($projectId->j_project_id),
            'statuses' => JSavingStatus::cases()
        ], Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new JSavingsValidator())->validate($data = new JSaving(), \request()->all());
        $family = Family::findOrFail($fid);
        $jeebika = Jeebika::firstWhere('family_id', $fid);
        $attributes['j_project_id'] = $jeebika->j_project_id;
        $attributes['j_gro_id'] = $jeebika->j_gro_id;
        $attributes['family_id'] = $family->id;
        $attributes['status'] = JSavingStatus::Pending;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Savings has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = JSaving::with([
            'project:id,name',
            'gro:id,name',
            'collector:id,name',
            'created_user:id,name',
            'updated_user:id,name',
        ])->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = JSaving::findOrFail($id);
        if (JSavingStatus::Pending != $data->status) {
            return response()->json(["message" => "Only pending savings can be confirmed."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JSavingsValidator())->validate($data, \request()->all());
        $attributes['status'] = JSavingStatus::Confirmed;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Savings has been successfully confirmed.'], Response::HTTP_OK);
    }
}
