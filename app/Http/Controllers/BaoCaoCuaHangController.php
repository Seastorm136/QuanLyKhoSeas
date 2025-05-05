<?php

namespace App\Http\Controllers;

use App\Models\CuaHang;
use App\Models\ChiTietCuaHang;
use App\Models\PhieuNhapCuaHang;
use App\Models\HoaDon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NhapCuaHangExport;
use App\Exports\BanHangExport;
use App\Exports\ThuCuaHangExport;

class BaoCaoCuaHangController extends Controller
{
    public function index()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();

        return view('baocaocuahang.index', compact('cuaHang'));
    }

    // Báo cáo nhập cửa hàng
    public function nhapCuaHang(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_cua_hang = $cuaHang->ma_cua_hang;

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $sanPhamTrongCH = ChiTietCuaHang::where('ma_cua_hang', $ma_cua_hang)->pluck('ma_sp')->toArray();

        $query = PhieuNhapCuaHang::with(['sanPham', 'cuaHang', 'nhanVien'])
            ->where('ma_cua_hang', $ma_cua_hang)
            ->whereIn('ma_sp', $sanPhamTrongCH);
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_nhap', [$startDate, $endDate]);
        }
        $nhapCuaHang = $query->get();

        if ($request->has('export')) {
            return Excel::download(new NhapCuaHangExport($startDate, $endDate, $ma_cua_hang), 'bao_cao_nhap_cua_hang_' . $ma_cua_hang . '.xlsx');
        }

        return view('baocaocuahang.nhap_cua_hang', compact('cuaHang', 'nhapCuaHang', 'startDate', 'endDate'));
    }

    // Báo cáo bán hàng
    public function banHang(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_cua_hang = $cuaHang->ma_cua_hang;

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = HoaDon::with(['chiTietHoaDons.sanPham', 'nhanVien'])
            ->where('ma_nv', $ma_nv);
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_lap', [$startDate, $endDate]);
        }
        $banHang = $query->get();

        if ($request->has('export')) {
            return Excel::download(new BanHangExport($startDate, $endDate, $ma_cua_hang), 'bao_cao_ban_hang_' . $ma_cua_hang . '.xlsx');
        }

        return view('baocaocuahang.ban_hang', compact('banHang', 'startDate', 'endDate'));
    }

    // Báo cáo thu cửa hàng
    public function thuCuaHang(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_cua_hang = $cuaHang->ma_cua_hang;

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = HoaDon::with(['nhanVien'])
            ->where('ma_nv', $ma_nv);
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_lap', [$startDate, $endDate]);
        }
        $thuCuaHang = $query->get();

        if ($request->has('export')) {
            return Excel::download(new ThuCuaHangExport($startDate, $endDate, $ma_cua_hang), 'bao_cao_thu_cua_hang_' . $ma_cua_hang . '.xlsx');
        }

        return view('baocaocuahang.thu_cua_hang', compact('thuCuaHang', 'startDate', 'endDate'));
    }
}