<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPermissionsController extends Controller
{
    public function index()
    {
        return view('user_permissions');
    }
}
