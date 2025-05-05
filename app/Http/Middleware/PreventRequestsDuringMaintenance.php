<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    protected $except = [
        // Các URL không bị chặn trong chế độ bảo trì
        '/staff/login',
        '/admin/*',
    ];
}