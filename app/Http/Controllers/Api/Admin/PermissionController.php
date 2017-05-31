<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Return list of Permissions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $permissions = Permission::all();
        return response()->json([
            'permissions' => $permissions
        ], 200);
    }

    /**
     * Return list of Roles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function roles()
    {
        $roles = Role::get();
        return response()->json([
            'roles' => $roles
        ], 200);
    }

    /**
     * Store created permission,
     * attach it to relevant roles
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:40|alpha_dash',
        ]);

        $name = $request->name;
        $permission = new Permission();
        $permission->name = $name;
        $permission->save();

        $roles = $request->roles;

        if (!empty($roles)) {
            foreach ($roles as $role) {
                $r = Role::where('id', $role)->firstOrFail();

                $permission = Permission::where('name', $name)->first();
                $r->givePermissionTo($permission);
            }
        }
    }

    /**
     * Update selected Permission
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $this->validate($request, [
            'name'=>'required|max:40|alpha_dash',
        ]);
        $input = $request->all();
        $permission->fill($input)->save();
    }

    /**
     * Delete selected Permission
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        //Make it impossible to delete this specific permission
        if ($permission->name == "Administer roles & permissions") {
            return response()->json([
                'error' => ['You can\'t delete this Permission!']
            ], 422);
        }

        $permission->delete();
    }
}
