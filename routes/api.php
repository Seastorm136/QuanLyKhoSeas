<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});