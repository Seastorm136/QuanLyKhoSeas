<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'nhan_vien';
    protected $primaryKey = 'ma_nv';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['ma_nv', 'ten_nv', 'gioitinh', 'ngay_sinh', 'so_dt',  'dia_chi', 'chuc_vu', 'ten_tknh', 'so_tknh', 'ten_dn'];

    public function staffLogin()
    {
        return $this->belongsTo(StaffLogin::class, 'ten_dn', 'staff_name');
    }

    public function khoHangs()
    {
        return $this->hasMany(KhoHang::class, 'ma_nv', 'ma_nv');
    }

    public function cuaHangs()
    {
        return $this->hasMany(CuaHang::class, 'ma_nv', 'ma_nv');
    }

    public function hoaDons()
    {
        return $this->hasMany(HoaDon::class, 'ma_nv', 'ma_nv');
    }
}