<?php

namespace App\Http\Controllers;

use App\Models\KhoHang;
use App\Models\CuaHang;
use Illuminate\Http\Request;

class TaoPhieuController extends Controller
{
    public function warehouseIndex()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        return view('taophieu.warehouse_index', compact('nhanVien'));
    }

    public function storeIndex()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_cua_hang = $cuaHang->ma_cua_hang;

        return view('taophieu.store_index', compact('nhanVien'));
    }
}