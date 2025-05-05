<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhieuNhapCuaHang extends Model
{
    protected $table = 'phieu_nhap_cua_hang';
    protected $primaryKey = 'ma_phieu_nhap_ch';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'ma_phieu_nhap_ch', 'ngay_nhap', 'ma_cua_hang', 'ma_sp', 'so_luong_nhap', 'ma_nv'
    ];

    public function cuaHang()
    {
        return $this->belongsTo(CuaHang::class, 'ma_cua_hang', 'ma_cua_hang');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'ma_sp', 'ma_sp');
    }

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'ma_nv', 'ma_nv');
    }
}