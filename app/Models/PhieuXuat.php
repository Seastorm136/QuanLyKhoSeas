<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhieuXuat extends Model
{
    protected $table = 'phieu_xuat';
    protected $primaryKey = 'ma_phieu_xuat';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [ 'ma_phieu_xuat', 'ngay_xuat', 'ma_kho', 'ma_sp', 'so_luong_xuat', 'ma_nv'];

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