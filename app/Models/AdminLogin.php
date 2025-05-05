<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminLogin extends Authenticatable
{
    protected $table = 'admin_login';
    protected $primaryKey = 'admin_name';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['admin_name' ,'password', 'remember_token'];

    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->password;
    }
}