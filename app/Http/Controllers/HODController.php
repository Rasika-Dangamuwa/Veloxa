<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HODController extends Controller
{
    public function dashboard()
    {
        return view('dashboards.hod', [
            'user' => auth()->user(),
            'title' => 'Head of Department Dashboard'
        ]);
    }
}