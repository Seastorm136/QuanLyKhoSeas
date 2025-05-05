<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiSP extends Model
{
    protected $table = 'loai_sp';
    protected $primaryKey = 'loai_sp';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['loai_sp'];
    public $timestamps = false;

    public function sanPhams()
    {
        return $this->hasMany(SanPham::class, 'loai_sp', 'loai_sp');
    }
}