<?php

namespace App\Http\Controllers\Base\Acl;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Acl\User;
use App\Models\Validators\UserValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.base.acl.user');
    }

    public function getList(Request $request): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,office_id,created_at');
        $data = User::select(User::getColumns())
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%');
            })
            ->where('is_admin', false)->orderBy($sort, $type)->paginate($item);
        return response()->json(['lists' => $data, 'statuses' => UserStatus::cases()], Response::HTTP_OK);
    }

    public function create(): JsonResponse
    {
        $attributes = (new UserValidator())->validate($data = new User(), \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($id): JsonResponse
    {
        $data = User::with(['created_user:id,name,email', 'updated_user:id,name,email'])->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update($id): JsonResponse
    {
        $data = User::findOrFail($id);
        $attributes = (new UserValidator())->validate($data, \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => $data->name . ' has been successfully updated.'], Response::HTTP_OK);
    }
}
