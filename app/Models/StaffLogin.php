<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class StaffLogin extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'staff_login';
    protected $primaryKey = 'staff_name';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['staff_name', 'password', 'remember_token'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function nhanVien()
    {
        return $this->hasOne(NhanVien::class, 'ten_dn', 'staff_name');
    }

}