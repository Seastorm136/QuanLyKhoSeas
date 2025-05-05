<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function homeStore()
    {
        return view('home_store');
    }

    public function homeWarehouse()
    {
        return view('home_warehouse');
    }
}