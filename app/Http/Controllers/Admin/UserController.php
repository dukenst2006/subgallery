<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    public function index()
    {
        $roles = Role::all();
        return view('admin.users.index', compact('roles'));
    }

    // Create will be a vue component

    public function show()
    {
        return view('admin.users.show');
    }

    // Edit will be a vue component
}
