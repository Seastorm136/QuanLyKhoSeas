<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietKhoHang extends Model
{
    protected $table = 'chi_tiet_kho_hang';
    protected $primaryKey = ['ma_kho', 'ma_sp'];
    public $incrementing = false;
    protected $fillable = ['ma_kho', 'ma_sp', 'so_luong', 'ma_phieu_nhap', 'ma_phieu_xuat', 'ma_phieu_chuyen'];
    public $timestamps = false;

    public function khoHang()
    {
        return $this->belongsTo(KhoHang::class, 'ma_kho', 'ma_kho');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'ma_sp', 'ma_sp');
    }

    public function loaiSP()
    {
        return $this->belongsTo(LoaiSP::class, 'loai_sp', 'loai_sp');
    }

    public function phieuNhap()
    {
        return $this->belongsTo(PhieuNhap::class, 'ma_phieu_nhap', 'ma_phieu_nhap');
    }

    public function phieuXuat()
    {
        return $this->belongsTo(PhieuXuat::class, 'ma_phieu_xuat', 'ma_phieu_xuat');
    }

    public function phieuChuyenKhoNguon()
    {
        return $this->belongsTo(PhieuChuyenKho::class, 'ma_phieu_chuyen', 'ma_phieu_chuyen');
    }

    public function phieuChuyenKhoDich()
    {
        return $this->belongsTo(phieuChuyenKho::class, 'ma_phieu_chuyen', 'ma_phieu_chuyen');
    }
}