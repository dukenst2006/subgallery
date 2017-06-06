<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Return a list of Roles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $roles = Role::with('permissions')
            ->get();
        $permissions = Permission::all();
        return response()->json([
            'roles' => $roles,
            'permissions' => $permissions
        ], 200);
    }

    /**
     * Return a list of Permissions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function permissions()
    {
        $permissions = Permission::all();
        return response()->json([
            'permissions' => $permissions
        ], 200);
    }

    /**
     * Store created Role,
     * attach relevant permissions to it
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'name' => 'required|unique:roles|max:15|alpha_dash',
                'permissions' => 'required',
            ]
        );

        $name = $request->name;
        $role = new Role();
        $role->name = $name;
        $role->save();

        $permissions = $request->permissions;

        foreach ($permissions as $permission) {
            $p = Permission::where('id', $permission)->firstOrFail();
//            $role = Role::where('name', $name)->first();
            $role->givePermissionTo($p);
        }
    }

    /**
     * Update selected Role
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        $role = Role::findOrFail($request->id);

        $this->validate($request, [
            'name'=>'required|alpha_dash|max:15|unique:roles,name,'.$request->id,
            'permissions' =>'required',
        ]);

        $role->name = $request->name;
        $role->save();
        $permissions = $request->permissions;

        $all = Permission::all();
        foreach ($all as $permission) {
            $role->revokePermissionTo($permission);
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', $permission)->firstOrFail();
            $role->givePermissionTo($p);
        }
    }

    /**
     * Delete selected Role
     *
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $role = Role::findOrFail($request->id);



        $role->delete();
    }
}
