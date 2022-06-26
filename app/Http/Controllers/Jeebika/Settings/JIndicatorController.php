<?php

namespace App\Http\Controllers\Jeebika\Settings;

use App\Enums\IndicatorStatus;
use App\Enums\IndicatorType;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\Settings\JIndicator;
use App\Models\Validators\JIndicatorValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JIndicatorController extends Controller
{

    public function index(): Renderable
    {
        return view('dashboard.jeebika.settings.indicator');
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,program_type,type,status,created_at');
        $data = JIndicator::select(JIndicator::listKey())
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%')
                    ->orWhere('type', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists' => $data,
            'statuses' => IndicatorStatus::cases(),
            'programTypes' => getIndicatorProgramTypesOnlyNames(),
            'types' => IndicatorType::cases(),
        ], Response::HTTP_OK);
    }

    public function create(): JsonResponse
    {
        $attributes = (new JIndicatorValidator())->validate($data = new JIndicator(), request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($id): JsonResponse
    {
        $data = JIndicator::with(['created_user:id,name', 'updated_user:id,name'])->select(JIndicator::listKey())->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update($id): JsonResponse
    {
        $data = JIndicator::findOrFail($id);
        $attributes = (new JIndicatorValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $data = JIndicator::findOrFail($id);
        try {
            $data->forceDelete();
            customSoftDelete(JIndicator::class, $data);
        } catch (Exception $e) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }
}
