<?php

namespace App\Http\Controllers\Base\Acl;

use App\Http\Controllers\Controller;
use App\Models\Base\Acl\Permission;
use App\Models\Base\Acl\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserRoleController extends Controller
{
    public function index()
    {
        return view('dashboard.base.acl.user-role');
    }

    public function getList()
    {
        $roles = Role::select(["id", "name", "created_at"])->orderBy("name")->get();
        return response()->json(["roles" => $roles, "permissions" => $this->_permissions()], Response::HTTP_OK);
    }

    private function _permissions()
    {
        $processed = [];
        $permissions = Permission::get();
        $data = $permissions->groupBy('group_name')->all();
        foreach ($data as $firstKey => $firstItems) {
            $rows = $firstItems->map(function ($firstItem) {
                $name = explode('.', $firstItem->name);
                $firstItem->child_one = $name[0] ?? null;
                return $firstItem;
            })->groupBy('child_one')->all();

            foreach ($rows as $secondKey => $secondItems) {
                $rows = $secondItems->map(function ($secondItem) {
                    $name = explode('.', $secondItem->name);
                    $secondItem->child_two = $name[1] ?? null;
                    $secondItem->name = $name[2] ?? null;
                    return $secondItem;
                })->groupBy('child_two')->all();


                $processed[$firstKey][$secondKey] = $rows;
                foreach ($rows as $k => $i) {
                    $processed[$firstKey][$secondKey][$k] = $i->pluck('name', 'id');
                }


            }
        }
        return $processed;
    }

    public function create(Request $request)
    {
        $request->validate([
            "name" => 'required|string|max:30|unique:roles,name',
            "permissions" => 'required|array|min:1|max:9999',
            'permissions.*' => 'required|numeric|digits_between:1,999999'
        ], [
            'permissions.required' => 'Please select at least one permission'
        ]);

        $permissions = $request->post("permissions") ?? NULL;
        $role = Role::create(['name' => $request->post("name")]);
        if ($permissions && count($permissions) > 0)
            $role->syncPermissions($permissions);

        return response()->json(["success" => $role->name . " has been successfully created."], Response::HTTP_OK);
    }

    public function getElementById($id)
    {
        $role = Role::with([
            'permissions' => function ($query) {
                $query->select('id');
            }
        ])->select(["id", "name"])->findOrfail($id);
        $role = json_decode(json_encode($role));
        if ($role->permissions) {
            $data = [];
            foreach ($role->permissions as $item) {
                $data[] = $item->id;
            }
            $role->permissions = $data;
        }
        return response()->json(["role" => $role, "permissions" => $this->_permissions()], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => 'required|string|max:30|unique:roles,name,' . $id,
            "permissions" => 'required|array|min:1|max:9999',
            'permissions.*' => 'required|numeric|digits_between:1,999999'
        ], [
            'permissions.required' => 'Please select at least one permission'
        ]);

        $role = Role::findOrfail($id);
        $role->name = $request->post("name");
        $role->save();
        $permissions = $request->post("permissions") ?? NULL;
        $role->syncPermissions($permissions);
        return response()->json(["success" => $role->name . " has been successfully updated."], Response::HTTP_OK);
    }

    public function delete($id)
    {
        $role = Role::findOrfail($id);
        try {
            $role->forceDelete();
        } catch (\Exception $e) {
            if (!$role->delete()) {
                return response()->json(["message" => $role->name . " in used"], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        return response()->json(["success" => $role->name . " has been successfully deleted"], Response::HTTP_OK);
    }
}
