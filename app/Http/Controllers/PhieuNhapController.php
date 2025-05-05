<?php

namespace App\Http\Controllers;

use App\Models\PhieuNhap;
use App\Models\KhoHang;
use App\Models\SanPham;
use App\Models\Von;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhieuNhapController extends Controller
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

        return view('phieunhap.create', compact('sanPhams', 'nhanVien', 'khoHang'));
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
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        $today = now()->format('Ymd');
        $lastPhieu = PhieuNhap::where('ma_phieu_nhap', 'like', "PN-$today%")
            ->orderBy('ma_phieu_nhap', 'desc')
            ->first();
        $stt = $lastPhieu ? (int)substr($lastPhieu->ma_phieu_nhap, -3) + 1 : 1;
        $maPhieuNhap = "PN-$today-" . str_pad($stt, 3, '0', STR_PAD_LEFT);

        $sanPham = SanPham::findOrFail($request->ma_sp);
        $giaNhap = $sanPham->gia_nhap;
        $chiPhi = $request->so_luong_nhap * $giaNhap;

        $phieuNhap = PhieuNhap::create([
            'ma_phieu_nhap' => $maPhieuNhap,
            'ngay_nhap' => $request->ngay_nhap,
            'ma_kho' => $ma_kho,
            'ma_sp' => $request->ma_sp,
            'so_luong_nhap' => $request->so_luong_nhap,
            'gia_nhap' => $giaNhap,
            'ma_nv' => $request->ma_nv,
        ]);

        $existingRecord = DB::table('chi_tiet_kho_hang')
            ->where('ma_kho', $ma_kho)
            ->where('ma_sp', $request->ma_sp)
            ->first();

        if ($existingRecord) {
            DB::table('chi_tiet_kho_hang')
                ->where('ma_kho', $ma_kho)
                ->where('ma_sp', $request->ma_sp)
                ->increment('so_luong', (int)$request->so_luong_nhap);
        } else {
            DB::table('chi_tiet_kho_hang')->insert([
                'ma_kho' => $ma_kho,
                'ma_sp' => $request->ma_sp,
                'loai_sp' => $sanPham->loai_sp,
                'so_luong' => (int)$request->so_luong_nhap,
            ]);
        }

        $von = Von::firstOrCreate(
            ['ma_kho' => $ma_kho],
            ['tong_von' => 0, 'ngay_cap_nhat' => now()]
        );
        $von->tong_von -= $chiPhi;
        $von->ngay_cap_nhat = now();
        $von->save();

        return redirect()->route('tao-phieu.warehouse_index')->with('success', 'Thêm phiếu nhập thành công!');
    }
}