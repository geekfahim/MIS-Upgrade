<?php

namespace App\Http\Controllers\Jeebika\Settings;

use App\Http\Controllers\Controller;
use App\Models\Base\Acl\User;
use App\Models\Jeebika\Settings\JArea;
use App\Models\Jeebika\Settings\JZone;
use App\Models\Jeebika\Validators\JAreaValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JAreaController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.jeebika.settings.area');
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request);
        $data = JArea::with(['j_zone:id,name', 'manager:id,name'])->select(JArea::listKey())
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists' => $data,
            'jZones' => JZone::getAll(['id', 'name']),
            'managers' => User::getAllWithOfficeID()
        ], Response::HTTP_OK);
    }

    public function create(): JsonResponse
    {
        $attributes = (new JAreaValidator())->validate($data = new JArea(), \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($id): JsonResponse
    {
        $data = JArea::with(['manager:id,name', 'j_zone:id,name', 'created_user:id,name', 'updated_user:id,name'])->select(JArea::listKey())->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update($id): JsonResponse
    {
        $data = JArea::findOrFail($id);
        $attributes = (new JAreaValidator())->validate($data, \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $data = JArea::findOrFail($id);
        try {
            $data->forceDelete();
            customSoftDelete(JArea::class, $data);
        } catch (Exception $e) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }
}
