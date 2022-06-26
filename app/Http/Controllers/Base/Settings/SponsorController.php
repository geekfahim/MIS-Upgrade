<?php

namespace App\Http\Controllers\Base\Settings;

use App\Enums\SponsorStatus;
use App\Enums\SponsorType;
use App\Http\Controllers\Controller;
use App\Models\Base\Settings\Sponsor;
use App\Models\Validators\SponsorValidator;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SponsorController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.base.settings.sponsor');
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request);
        $data = Sponsor::select(Sponsor::listKey())
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%')
                    ->orWhere('address', 'LIKE', '%' . $query . '%')
                    ->orWhere('type', 'LIKE', '%' . $query . '%');
            })->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists' => $data,
            'statuses' => SponsorStatus::cases(),
            'types' => SponsorType::cases()
        ], Response::HTTP_OK);
    }

    public function create(): JsonResponse
    {
        $attributes = (new SponsorValidator())->validate($data = new Sponsor(), \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($id): JsonResponse
    {
        $data = Sponsor::with(['created_user:id,name', 'updated_user:id,name'])->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update($id): JsonResponse
    {
        $data = Sponsor::findOrFail($id);
        $attributes = (new SponsorValidator())->validate($data, \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $data = Sponsor::findOrFail($id);
        try {
            $data->forceDelete();
            customSoftDelete(Sponsor::class, $data);
        } catch (Exception $e) {
            return response()->json(['message' => $data->name . ' in used.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json(['success' => $data->name . ' has been successfully deleted.'], Response::HTTP_OK);
    }
}
