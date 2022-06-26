<?php

namespace App\Http\Controllers\Base\Settings;

use App\Http\Controllers\Controller;
use App\Models\Base\Settings\Upazila;
use App\Models\Validators\UpazilaValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UpazilaController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.base.settings.upazila');
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request);
        $data = Upazila::with('district:id,name')
            ->when($query, function ($sql) use ($query) {
                $sql->whereHas('district', function ($builder) use ($query) {
                    $builder->where('name', 'LIKE', '%' . $query . '%');
                })->orWhere('name', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json($data, Response::HTTP_OK);
    }

    public function getElementById($id): JsonResponse
    {
        $data = Upazila::with(['district:id,name as text', 'created_user:id,name', 'updated_user:id,name'])->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $attributes = (new UpazilaValidator())->validate($data = new Upazila(), $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = Upazila::findOrFail($id);
        $attributes = (new UpazilaValidator())->validate($data, $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $data = Upazila::findOrFail($id);
        try {
            $data->forceDelete();
            customSoftDelete(Upazila::class, $data);
        } catch (Exception $e) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }
}
