<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserRolController extends Controller
{
    public function index()
    {
        return view('userRol.index');
    }
}
