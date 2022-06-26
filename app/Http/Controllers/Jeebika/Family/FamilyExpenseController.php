<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Enums\FamilyExpenseType;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyExpense;
use App\Models\Validators\FamilyExpenseValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FamilyExpenseController extends Controller
{

    public function getList($fid): JsonResponse
    {
        $keys = ['id', 'expense_type', 'expense_amount', 'expense_remarks'];
        $data = FamilyExpense::getAllByFamilyId($fid, $keys);
        return response()->json(['lists' => $data, 'EXPENSE_TYPES' => FamilyExpenseType::cases()], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = FamilyExpense::where('family_id', $fid)->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new FamilyExpenseValidator())->validate($data = new FamilyExpense(), array_merge(request()->all(), ['family_id' => $fid]));
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Expense has been successfully created.'], Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = FamilyExpense::where('family_id', $fid)->findOrFail($id);
        $attributes = (new FamilyExpenseValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Expense has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = FamilyExpense::where('family_id', $fid)->findOrFail($id);
        if (!$item->delete()) return response()->json(['message' => 'Expense in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'Expense has been successfully deleted'], Response::HTTP_OK);
    }
}
