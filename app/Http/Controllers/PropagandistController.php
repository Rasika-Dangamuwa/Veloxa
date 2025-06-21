<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PropagandistController extends Controller
{
    public function dashboard()
    {
        return view('dashboards.propagandist', [
            'user' => auth()->user(),
            'title' => 'Propagandist Dashboard'
        ]);
    }
}