<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function dashboard()
    {
        return view('dashboards.warehouse', [
            'user' => auth()->user(),
            'title' => 'Warehouse Dashboard'
        ]);
    }
}