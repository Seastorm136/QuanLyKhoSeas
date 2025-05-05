<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    protected $table = 'chi_tiet_hoa_don';
    protected $primaryKey = ['ma_hoa_don', 'ma_sp'];
    public $incrementing = false;
    protected $fillable = ['ma_hoa_don', 'ma_sp', 'so_luong', 'don_gia', 'thanh_tien'];

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'ma_sp', 'ma_sp');
    }

    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class, 'ma_hoa_don', 'ma_hoa_don');
    }
}