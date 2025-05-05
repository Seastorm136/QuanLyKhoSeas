<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'san_pham';
    protected $primaryKey = 'ma_sp';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['ma_sp', 'ten_sp', 'don_vi_tinh', 'gia_nhap', 'ban_buon', 'ban_le', 'loai_sp'];

    public function loaiSP()
    {
        return $this->belongsTo(LoaiSP::class, 'loai_sp', 'loai_sp');
    }

    public function chiTietKhoHang()
    {
        return $this->hasMany(ChiTietKhoHang::class, 'ma_sp', 'ma_sp');
    }

    public function chiTietCuaHang()
    {
        return $this->hasMany(ChiTietCuaHang::class, 'ma_sp', 'ma_sp');
    }
}