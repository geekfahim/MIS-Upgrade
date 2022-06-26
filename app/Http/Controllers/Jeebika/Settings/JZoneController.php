<?php

namespace App\Http\Controllers\Jeebika\Settings;

use App\Http\Controllers\Controller;
use App\Models\Base\Acl\User;
use App\Models\Jeebika\Settings\JZone;
use App\Models\Jeebika\Validators\JZoneValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class JZoneController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.jeebika.settings.zone');
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request);
        $data = JZone::with('manager:id,name')->select(Jzone::listKey())
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists' => $data,
            'managers' => User::getAllWithOfficeID()
        ], Response::HTTP_OK);
    }

    public function create(): JsonResponse
    {
        $attributes = (new JZoneValidator())->validate($data = new JZone(), \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($id)
    {
        $data = Jzone::with(['manager:id,name', 'created_user:id,name', 'updated_user:id,name'])->select(Jzone::listKey())->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update($id): JsonResponse
    {
        $data = JZone::findOrFail($id);
        $attributes = (new JZoneValidator())->validate($data, \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $data = JZone::findOrFail($id);
        try {
            $data->forceDelete();
            customSoftDelete(JZone::class, $data);
        } catch (Exception $e) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }
}
