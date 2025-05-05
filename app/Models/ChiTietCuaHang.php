<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietCuaHang extends Model
{
    protected $table = 'chi_tiet_cua_hang';
    protected $primaryKey = ['ma_cua_hang', 'ma_sp'];
    public $incrementing = false;
    protected $fillable = ['ma_cua_hang', 'ma_sp', 'so_luong'];
    public $timestamps = false;

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'ma_sp', 'ma_sp');
    }

    public function cuaHang()
    {
        return $this->belongsTo(CuaHang::class, 'ma_cua_hang', 'ma_cua_hang');
    }
}