<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Von extends Model
{
    protected $table = 'von';
    protected $fillable = ['ma_kho', 'tong_von', 'ngay_cap_nhat'];

    protected $casts = [
        'ngay_cap_nhat' => 'datetime',
    ];
    
    public function kho()
    {
        return $this->belongsTo(KhoHang::class, 'ma_kho', 'ma_kho');
    }
}