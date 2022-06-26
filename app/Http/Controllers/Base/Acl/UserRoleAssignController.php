<?php

namespace App\Http\Controllers\Base\Acl;

use App\Http\Controllers\Controller;
use App\Models\Base\Acl\Role;
use App\Models\Base\Acl\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserRoleAssignController extends Controller
{
    public function index()
    {
        return view('dashboard.base.acl.user-role-assign');
    }

    public function getList(Request $request)
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'name,status,created_at');
        $roles = Role::all()->pluck("name");

        $item = User::with(['roles' => function ($sql) {
            $sql->select('id', 'name');
        }
        ])->select('id', 'name', 'created_at')
            ->where('is_admin', false)
            ->when($query, function ($sql) use ($query) {
                $sql->where('name', 'LIKE', '%' . $query . '%');
            })
            ->role($roles)
            ->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists' => $item,
            'users' => User::getAllWithOfficeID(),
            'roles' => Role::select('id', 'name as text')->orderBy('name')->get()
        ], Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        $request->validate([
            "user_id" => 'required|numeric|digits_between:1,10',
            "role_ids" => 'required|array|max:99',
            'role_ids.*' => 'required|digits_between:1,10'
        ], [
            "user_id.required" => "Must select user",
            "role_ids.required" => "Must select user at least one"
        ]);

        $roleIds = $request->post("role_ids") ?? NULL;
        $roles = Role::whereIn("id", $roleIds);
        if (!$roles->exists()) {
            return response()->json(["message" => "Sorry roles not found."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $uid = $request->post("user_id") ?? NULL;
        $user = User::findOrFail($uid);

        $roles = $roles->get()->pluck("name");
        $user->assignRole($roles);

        return response()->json(["success" => "User role has been successfully created."], Response::HTTP_OK);

    }

    public function getElementById($id)
    {
        $data = [];
        $user = User::select('id', 'name', 'office_id')->findOrFail($id);
        $userRoles = $user->getRoleNames();
        $roleIds = Role::select('id', 'name as text')->whereIn("name", $userRoles)->get()->pluck('id');
        $data['user_id'] = $user->id;
        $data['role_ids'] = $roleIds;
        $data['users'] = array_map(fn($item) => ['id' => $item->id, 'text' => $item->name . ' (' . $item->office_id . ')'], [$user]);
        return response()->json($data, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "user_id" => 'required|numeric|digits_between:1,10',
            "role_ids" => 'required|array|max:99',
            'role_ids.*' => 'required|digits_between:1,10'
        ], [
            "user_id.required" => "Must select user",
            "role_ids.required" => "Must select user at least one"
        ]);
        $roleIds = $request->post("role_ids") ?? NULL;
        $roles = Role::whereIn("id", $roleIds);
        if (!$roles->exists()) {
            return response()->json(["message" => "Sorry roles not found"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = User::findOrFail($id);
        if (!$user->exists()) {
            return response()->json(["message" => "Sorry user not found"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $roles = $roles->get()->pluck("name");
        $user->syncRoles($roles);
        return response()->json(["success" => "User role has been successfully Updated."], Response::HTTP_OK);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $roles = $user->getRoleNames();
        try {
            foreach ($roles as $role) {
                $user->removeRole($role);
            }
            return response()->json(["success" => $user->full_name . " role has been successfully deleted."], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["message" => $user->full_name . " role can not be delete."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
