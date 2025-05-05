<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhieuNhap extends Model
{
    protected $table = 'phieu_nhap';
    protected $primaryKey = 'ma_phieu_nhap';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [ 'ma_phieu_nhap', 'ngay_nhap', 'ma_kho', 'ma_sp', 'so_luong_nhap', 'gia_nhap', 'ma_nv'];

    public function khoHang()
    {
        return $this->belongsTo(KhoHang::class, 'ma_kho', 'ma_kho');
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