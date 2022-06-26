<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Enums\FamilyLoanPurposeType;
use App\Enums\FamilyLoanSourceType;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyLoan;
use App\Models\Validators\FamilyLoanValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FamilyLoanController extends Controller
{

    public function getList($fid): JsonResponse
    {
        $keys = ['id', 'loan_taking_date', 'loan_source', 'loan_source_name', 'loan_amount', 'loan_rate_or_extra_amount', 'loan_duration', 'loan_purpose', 'loan_outstanding_amount', 'loan_remarks'];
        $data = FamilyLoan::getAllByFamilyId($fid, $keys);
        return response()->json([
            'lists' => $data,
            'SOURCE_TYPES' => FamilyLoanSourceType::cases(),
            'PURPOSE_TYPES' => FamilyLoanPurposeType::cases()
        ], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = FamilyLoan::where('family_id', $fid)->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new FamilyLoanValidator())->validate($data = new FamilyLoan(), array_merge(request()->all(), ['family_id' => $fid]));
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Loan has been successfully created.'], Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = FamilyLoan::where('family_id', $fid)->findOrFail($id);
        $attributes = (new FamilyLoanValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Loan has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = FamilyLoan::where('family_id', $fid)->findOrFail($id);
        if (!$item->delete()) return response()->json(['message' => 'Loan in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'Loan has been successfully deleted'], Response::HTTP_OK);
    }
}
