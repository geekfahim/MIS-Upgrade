<?php

namespace App\Http\Controllers\Base\Settings;

use App\Http\Controllers\Controller;
use App\Models\Base\Settings\Disease;
use App\Models\Validators\DiseaseValidator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DiseaseController extends Controller
{
    public function index()
    {
        return view('dashboard.base.settings.disease');
    }

    public function getList(Request $request)
    {
        list($sort, $type, $query, $item) = getListValidation($request);
        $data = Disease::select(Disease::getColumns())
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json($data, Response::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $attributes = (new DiseaseValidator())->validate($data = new Disease(), $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.']);
    }

    public function getElementById($id): JsonResponse
    {
        $data = Disease::with(['created_user:id,name', 'updated_user:id,name'])->select(Disease::getColumns())->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update(Request $request, $id): JsonResponse
    {

        $data = Disease::findOrFail($id);
        $attributes = (new DiseaseValidator())->validate($data, $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $data = Disease::findOrFail($id);
        try {
            $data->forceDelete();
            customSoftDelete(Disease::class, $data);
        } catch (Exception $e) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }
}
