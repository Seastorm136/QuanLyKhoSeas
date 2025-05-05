<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table = 'hoa_don';
    protected $primaryKey = 'ma_hoa_don';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['ma_hoa_don', 'ngay_lap', 'ma_nv', 'tong_tien'];
    public $timestamps = false;

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'ma_nv', 'ma_nv');
    }

    public function chiTietHoaDons()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'ma_hoa_don', 'ma_hoa_don');
    }
}