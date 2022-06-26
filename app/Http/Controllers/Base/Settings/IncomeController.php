<?php

namespace App\Http\Controllers\Base\Settings;

use App\Http\Controllers\Controller;
use App\Models\Base\Settings\Income;
use App\Models\Validators\IncomeValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IncomeController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.base.settings.income');
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request);
        $data = Income::select(Income::getColumns())
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json($data, Response::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $attributes = (new IncomeValidator())->validate($data = new Income(), $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($id): JsonResponse
    {
        $data = Income::with(['created_user:id,name', 'updated_user:id,name'])->select(Income::getColumns())->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = Income::findOrFail($id);
        $attributes = (new IncomeValidator())->validate($data, $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $data = Income::findOrFail($id);
        try {
            $data->forceDelete();
            customSoftDelete(Income::class, $data);
        } catch (Exception $e) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }
}
