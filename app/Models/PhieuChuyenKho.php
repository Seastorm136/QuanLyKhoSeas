<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhieuChuyenKho extends Model
{
    protected $table = 'phieu_chuyen_kho';
    protected $primaryKey = 'ma_phieu_chuyen';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'ma_phieu_chuyen', 'ngay_chuyen', 'ma_kho_nguon', 'ma_kho_dich', 'ma_sp', 'so_luong_chuyen_den', 'so_luong_chuyen_di' , 'ma_nv'
    ];

    public function khoNguon()
    {
        return $this->belongsTo(KhoHang::class, 'ma_kho_nguon', 'ma_kho');
    }

    public function khoDich()
    {
        return $this->belongsTo(KhoHang::class, 'ma_kho_dich', 'ma_kho');
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