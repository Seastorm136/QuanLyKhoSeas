<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhoHang extends Model
{
    protected $table = 'kho_hang';
    protected $primaryKey = 'ma_kho';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['ma_kho', 'ten_kho', 'ma_nv', 'so_luong_sp'];

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'ma_nv', 'ma_nv');
    }

    public function chiTietKhoHang()
    {
        return $this->hasMany(ChiTietKhoHang::class, 'ma_kho', 'ma_kho');
    }
}