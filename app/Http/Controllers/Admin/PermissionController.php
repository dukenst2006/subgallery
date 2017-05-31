<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    public function index()
    {
        return view('admin.permissions.index');
    }

    // Create will be a vue component

    public function show()
    {
        return view('admin.permissions.show');
    }

    // Edit will be a vue component
}
