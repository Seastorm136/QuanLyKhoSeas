<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VonLuuDong extends Model
{
    protected $table = 'von_luu_dong';
    protected $fillable = ['tong_von_luu_dong', 'ngay_cap_nhat'];
}