<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuaHang extends Model
{
    protected $table = 'cua_hang';
    protected $primaryKey = 'ma_cua_hang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['ma_cua_hang', 'ten_cua_hang', 'ma_nv', 'so_luong_sp'];
    public $timestamps = false;

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'ma_nv', 'ma_nv');
    }

    public function chiTietCuaHang()
    {
        return $this->hasMany(ChiTietCuaHang::class, 'ma_cua_hang', 'ma_cua_hang');
    }
}