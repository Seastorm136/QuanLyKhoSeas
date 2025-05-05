<?php

namespace App\Http\Controllers;

use App\Models\PhieuNhapCuaHang;
use App\Models\CuaHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhieuNhapCuaHangController extends Controller
{
    public function create()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_cua_hang = $cuaHang->ma_cua_hang;

        $chiTietCuaHang = DB::table('chi_tiet_cua_hang')->where('ma_cua_hang', $ma_cua_hang)->get();
        $sanPhams = SanPham::whereIn('ma_sp', $chiTietCuaHang->pluck('ma_sp'))
            ->get()
            ->map(function ($sanPham) use ($chiTietCuaHang) {
                $sanPham->so_luong_ton = $chiTietCuaHang->firstWhere('ma_sp', $sanPham->ma_sp)->so_luong ?? 0;
                return $sanPham;
            });

        return view('phieunhapcuahang.create', compact('sanPhams', 'nhanVien', 'cuaHang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ngay_nhap' => 'required|date',
            'ma_sp' => 'required|exists:san_pham,ma_sp',
            'so_luong_nhap' => 'required|integer|min:1',
            'ma_nv' => 'required|exists:nhan_vien,ma_nv',
        ]);

        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_cua_hang = $cuaHang->ma_cua_hang;

        $today = now()->format('Ymd');
        $lastPhieu = PhieuNhapCuaHang::where('ma_phieu_nhap_ch', 'like', "PH-$today%")
            ->orderBy('ma_phieu_nhap_ch', 'desc')
            ->first();
        $stt = $lastPhieu ? (int)substr($lastPhieu->ma_phieu_nhap_ch, -3) + 1 : 1;
        $maPhieuNhapCuaHang = "PH-$today-" . str_pad($stt, 3, '0', STR_PAD_LEFT);

        $phieuNhapCuaHang = PhieuNhapCuaHang::create([
            'ma_phieu_nhap_ch' => $maPhieuNhapCuaHang,
            'ngay_nhap' => $request->ngay_nhap,
            'ma_cua_hang' => $ma_cua_hang,
            'ma_sp' => $request->ma_sp,
            'so_luong_nhap' => $request->so_luong_nhap,
            'ma_nv' => $request->ma_nv,
        ]);

        $existingRecord = DB::table('chi_tiet_cua_hang')
            ->where('ma_cua_hang', $ma_cua_hang)
            ->where('ma_sp', $request->ma_sp)
            ->first();

        if ($existingRecord) {
            DB::table('chi_tiet_cua_hang')
                ->where('ma_cua_hang', $ma_cua_hang)
                ->where('ma_sp', $request->ma_sp)
                ->increment('so_luong', (int)$request->so_luong_nhap);
        } else {
            DB::table('chi_tiet_cua_hang')->insert([
                'ma_cua_hang' => $ma_cua_hang,
                'ma_sp' => $request->ma_sp,
                'so_luong' => (int)$request->so_luong_nhap,
            ]);
        }

        return redirect()->route('tao-phieu.store_index')->with('success', 'Thêm phiếu nhập cửa hàng thành công!');
    }
}