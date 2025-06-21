<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function dashboard()
    {
        return view('dashboards.manager', [
            'user' => auth()->user(),
            'title' => 'Manager Dashboard'
        ]);
    }
}