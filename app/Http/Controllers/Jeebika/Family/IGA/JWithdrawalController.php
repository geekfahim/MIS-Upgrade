<?php

namespace App\Http\Controllers\Jeebika\Family\IGA;

use App\Enums\IGA\JWithdrawlStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\IGA\JWithdrawal;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\Validators\JWithdrawalValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JWithdrawalController extends Controller
{
    public function index($fid): Renderable
    {
        $family = Family::findOrFail($fid);
        return view('dashboard.jeebika.family.IGA.withdrawal', compact('family'));
    }

    public function getList(Request $request, $fid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'date,confirmed_amount,approved_amount,status,created_at');
        $data = JWithdrawal::select(JWithdrawal::listKey())
            ->when($query, function ($sql) use ($query) {
                $sql->where('confirmed_amount', 'LIKE', '%' . $query . '%');
            })
            ->where('family_id', $fid)->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists' => $data,
            'statuses' => JWithdrawlStatus::cases()
        ], Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new JWithdrawalValidator())->validate($data = new JWithdrawal(), \request()->all());
        $family = Family::findOrFail($fid);
        $jeebika = Jeebika::firstWhere('family_id', $fid);
        $attributes['j_project_id'] = $jeebika->j_project_id;
        $attributes['j_gro_id'] = $jeebika->j_gro_id;
        $attributes['family_id'] = $family->id;
        $attributes['status'] = JWithdrawlStatus::Pending;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Withdrawal has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = JWithdrawal::with([
            'project:id,name',
            'gro:id,name',
            'created_user:id,name',
            'updated_user:id,name',
        ])->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = JWithdrawal::findOrFail($id);
        if (JWithdrawlStatus::Pending != $data->status) {
            return response()->json(["message" => "Only pending withdrawal can be confirmed."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JWithdrawalValidator())->validate($data, \request()->all());
        $attributes['status'] = JWithdrawlStatus::Confirmed;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Withdrawal has been successfully confirmed.'], Response::HTTP_OK);
    }
}
