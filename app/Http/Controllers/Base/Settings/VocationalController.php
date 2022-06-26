<?php

namespace App\Http\Controllers\Base\Settings;

use App\Http\Controllers\Controller;
use App\Models\Base\Settings\Vocational;
use App\Models\Validators\VocationalValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VocationalController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.base.settings.vocational');
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request);
        $data = Vocational::select(['id', 'name', 'created_at'])
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json($data, Response::HTTP_OK);
    }

    public function create(): JsonResponse
    {
        $attributes = (new VocationalValidator())->validate($data = new Vocational(), \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($id): JsonResponse
    {
        $data = Vocational::with(['created_user:id,name', 'updated_user:id,name'])->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update($id): JsonResponse
    {
        $data = Vocational::findOrFail($id);
        $attributes = (new VocationalValidator())->validate($data, \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $data = Vocational::findOrFail($id);
        try {
            $data->forceDelete();
            customSoftDelete(Vocational::class, $data);
        } catch (Exception $e) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }
}
