<?php

namespace App\Http\Controllers\Base\Settings;

use App\Http\Controllers\Controller;
use App\Models\Base\Settings\Disaster;
use App\Models\Validators\DisasterValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DisasterController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.base.settings.disaster');
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request);
        $data = Disaster::select(Disaster::getColumns())
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json($data, Response::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $attributes = (new DisasterValidator())->validate($data = new Disaster(), $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.']);
    }

    public function getElementById($id): JsonResponse
    {
        $data = Disaster::with(['created_user:id,name', 'updated_user:id,name'])->select(Disaster::getColumns())->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = Disaster::findOrFail($id);
        $attributes = (new DisasterValidator())->validate($data, $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $data = Disaster::findOrFail($id);
        try {
            $data->forceDelete();
            customSoftDelete(Disaster::class, $data);
        } catch (Exception $e) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }
}
