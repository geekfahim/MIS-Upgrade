<?php

namespace App\Http\Controllers\Jeebika\Family\IGA;

use App\Enums\IGA\JMiscellaneousStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\IGA\JMiscellaneous;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\Validators\JMiscellaneousValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JMiscellaneousController extends Controller
{
    public function index($fid): Renderable
    {
        $family = Family::findOrFail($fid);
        return view('dashboard.jeebika.family.IGA.miscellaneous', compact('family'));
    }

    public function getList(Request $request, $fid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'date,confirmed_amount,approved_amount,status,created_at');
        $data = JMiscellaneous::select(JMiscellaneous::listKey())
            ->when($query, function ($sql) use ($query) {
                $sql->where('confirmed_amount', 'LIKE', '%' . $query . '%');
            })
            ->where('family_id', $fid)->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists' => $data,
            'statuses' => JMiscellaneousStatus::cases()
        ], Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new JMiscellaneousValidator())->validate($data = new JMiscellaneous(), \request()->all());
        $family = Family::findOrFail($fid);
        $jeebika = Jeebika::firstWhere('family_id', $fid);
        $attributes['j_project_id'] = $jeebika->j_project_id;
        $attributes['j_gro_id'] = $jeebika->j_gro_id;
        $attributes['family_id'] = $family->id;
        $attributes['status'] = JMiscellaneousStatus::Pending;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Miscellaneous has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $item = JMiscellaneous::with([
            'project:id,name',
            'gro:id,name',
            'created_user:id,name',
            'updated_user:id,name',
        ])->findOrFail($id);
        return response()->json(removeEmptyKey($item), Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = JMiscellaneous::findOrFail($id);
        if (JMiscellaneousStatus::Pending != $data->status) {
            return response()->json(["message" => "Only pending miscellaneous can be confirmed."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JMiscellaneousValidator())->validate($data, \request()->all());
        $attributes['status'] = JMiscellaneousStatus::Confirmed;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Miscellaneous has been successfully confirmed.'], Response::HTTP_OK);
    }
}
