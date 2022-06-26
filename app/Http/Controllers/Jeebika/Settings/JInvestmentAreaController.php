<?php

namespace App\Http\Controllers\Jeebika\Settings;

use App\Http\Controllers\Controller;
use App\Models\Jeebika\Settings\JInvestmentArea;
use App\Models\Jeebika\Validators\JInvestmentAreaValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JInvestmentAreaController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.jeebika.settings.investment-area');
    }

    public function getElementById($id): JsonResponse
    {
        $data = JInvestmentArea::with('created_user:id,name', 'updated_user:id,name')->select(JInvestmentArea::listKey())->findOrFail($id);
        return response()->json($data, Response::HTTP_OK);
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request);
        $data = JInvestmentArea::select(JInvestmentArea::listKey())
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json($data, Response::HTTP_OK);
    }

    public function create(): JsonResponse
    {
        $attributes = (new JInvestmentAreaValidator())->validate($data = new JInvestmentArea(), \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.']);
    }

    public function update($id): JsonResponse
    {
        $data = JInvestmentArea::findOrFail($id);
        $attributes = (new JInvestmentAreaValidator())->validate($data, \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $data = JInvestmentArea::findOrFail($id);
        try {
            $data->forceDelete();
            customSoftDelete(JInvestmentArea::class, $data);
        } catch (Exception $e) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }

}
