<?php

namespace App\Http\Controllers\Api\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Return a list of Users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::with('roles')
            ->get();
        return response()->json([
            'users' => $users
        ], 200);
    }

    /**
     * Return a list of Roles
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
     * Store a new user on the database
     * TODO: Vue Pagination of users
     * TODO: Fire off email to created user with password
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string|alpha_dash|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'roles' => 'required',
        ]);

        $password = str_random(16);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($password),
        ]);

        $role = Role::findOrFail($request->roles);
        $user->assignRole($role);
    }

    /**
     * Update selected user
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'username' => 'required|string|alpha_dash|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $roles = $request->roles;

        if (isset($roles)) {
            $user->roles()->sync($roles);
        }
        else {
            $user->roles()->detach();
        }
    }

    /**
     * Delete selected user
     *
     * @param $id
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
