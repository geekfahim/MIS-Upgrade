<?php

namespace App\Http\Controllers\Base\Settings;

use App\Http\Controllers\Controller;
use App\Models\Base\Settings\Union;
use App\Models\Validators\UnionValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnionController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.base.settings.union');
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request);
        $data = Union::with(['upazila:id,name'])
            ->when($query, function ($sql) use ($query) {
                $sql->whereHas('upazila', function ($builder) use ($query) {
                    $builder->where('name', 'LIKE', '%' . $query . '%');
                })->orWhere('name', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json($data, Response::HTTP_OK);
    }

    public function getElementById($id): JsonResponse
    {
        $data = Union::with(['upazila:id,name as text', 'created_user:id,name', 'updated_user:id,name'])->select(Union::getColumns())->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $attributes = (new UnionValidator())->validate($data = new Union(), $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = Union::findOrFail($id);
        $attributes = (new UnionValidator())->validate($data, $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $data = Union::findOrFail($id);
        try {
            $data->forceDelete();
            customSoftDelete(Union::class, $data);
        } catch (Exception $e) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }
}
