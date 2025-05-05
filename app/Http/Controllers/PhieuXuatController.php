<?php

namespace App\Http\Controllers;

use App\Models\PhieuXuat;
use App\Models\KhoHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhieuXuatController extends Controller
{
    public function create()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        $chiTietKho = DB::table('chi_tiet_kho_hang')->where('ma_kho', $ma_kho)->get();
        $sanPhams = SanPham::whereIn('ma_sp', $chiTietKho->pluck('ma_sp'))
            ->get()
            ->map(function ($sanPham) use ($chiTietKho) {
                $sanPham->so_luong_ton = $chiTietKho->firstWhere('ma_sp', $sanPham->ma_sp)->so_luong ?? 0;
                return $sanPham;
            });

        return view('phieuxuat.create', compact('sanPhams', 'nhanVien', 'khoHang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ngay_xuat' => 'required|date',
            'ma_sp' => 'required|exists:san_pham,ma_sp',
            'so_luong_xuat' => 'required|integer|min:1',
            'ma_nv' => 'required|exists:nhan_vien,ma_nv',
        ]);

        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        $today = now()->format('Ymd');
        $lastPhieu = PhieuXuat::where('ma_phieu_xuat', 'like', "PX-$today%")
            ->orderBy('ma_phieu_xuat', 'desc')
            ->first();
        $stt = $lastPhieu ? (int)substr($lastPhieu->ma_phieu_xuat, -3) + 1 : 1;
        $maPhieuXuat = "PX-$today-" . str_pad($stt, 3, '0', STR_PAD_LEFT);

        $chiTietKho = DB::table('chi_tiet_kho_hang')
            ->where('ma_kho', $ma_kho)
            ->where('ma_sp', $request->ma_sp)
            ->first();

        if (!$chiTietKho || $chiTietKho->so_luong < $request->so_luong_xuat) {
            return back()->withErrors(['so_luong_xuat' => 'Số lượng tồn kho không đủ để xuất!']);
        }

        $phieuXuat = PhieuXuat::create([
            'ma_phieu_xuat' => $maPhieuXuat,
            'ngay_xuat' => $request->ngay_xuat,
            'ma_kho' => $ma_kho,
            'ma_sp' => $request->ma_sp,
            'so_luong_xuat' => $request->so_luong_xuat,
            'ma_nv' => $request->ma_nv,
        ]);

        DB::table('chi_tiet_kho_hang')
            ->where('ma_kho', $ma_kho)
            ->where('ma_sp', $request->ma_sp)
            ->decrement('so_luong', (int)$request->so_luong_xuat);

        return redirect()->route('tao-phieu.warehouse_index')->with('success', 'Thêm phiếu xuất thành công!');
    }
}