<?php

namespace App\Http\Controllers;

use App\Models\PhieuNhap;
use App\Models\PhieuXuat;
use App\Models\PhieuChuyenKho;
use App\Models\KhoHang;
use App\Models\ChiTietKhoHang;
use App\Models\Von;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NhapKhoExport;
use App\Exports\XuatKhoExport;
use App\Exports\TonKhoExport;
use App\Exports\HangTonDongExport;
use App\Exports\ChuyenKhoExport;
use App\Exports\ChiKhoExport;
use App\Exports\VonKhoExport;

class BaoCaoKhoController extends Controller
{
    public function index()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();

        return view('baocaokho.index', compact('khoHang'));
    }

    // Báo cáo nhập kho
    public function nhapKho(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $sanPhamTrongKho = ChiTietKhoHang::where('ma_kho', $ma_kho)->pluck('ma_sp')->toArray();

        $query = PhieuNhap::with(['sanPham', 'khoHang', 'nhanVien'])
            ->where('ma_kho', $ma_kho)
            ->whereIn('ma_sp', $sanPhamTrongKho);
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_nhap', [$startDate, $endDate]);
        }
        $nhapKho = $query->get();

        if ($request->has('export')) {
            return Excel::download(new NhapKhoExport($startDate, $endDate, $ma_kho), 'bao_cao_nhap_kho_' . $ma_kho . '.xlsx');
        }

        return view('baocaokho.nhap_kho', compact('khoHang', 'nhapKho', 'startDate', 'endDate'));
    }

    // Báo cáo xuất kho
    public function xuatKho(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = PhieuXuat::with(['sanPham', 'khoHang', 'nhanVien'])
            ->where('ma_kho', $ma_kho);
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_xuat', [$startDate, $endDate]);
        }
        $xuatKho = $query->get();

        if ($request->has('export')) {
            return Excel::download(new XuatKhoExport($startDate, $endDate, $ma_kho), 'bao_cao_xuat_kho_' . $ma_kho . '.xlsx');
        }

        return view('baocaokho.xuat_kho', compact('khoHang', 'xuatKho', 'startDate', 'endDate'));
    }

    // Báo cáo tồn kho
    public function tonKho(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        $tonKho = ChiTietKhoHang::with('sanPham', 'khoHang')
            ->where('ma_kho', $ma_kho)
            ->get();

        if ($request->has('export')) {
            return Excel::download(new TonKhoExport($ma_kho), 'bao_cao_ton_kho_' . $ma_kho . '.xlsx');
        }

        return view('baocaokho.ton_kho', compact('khoHang', 'tonKho'));
    }

    // Báo cáo hàng tồn đọng
    public function hangTonDong(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        $days = $request->input('days', 30);
        $tonKho = ChiTietKhoHang::with('sanPham', 'khoHang')
            ->where('ma_kho', $ma_kho)
            ->whereDoesntHave('phieuNhap', function ($q) use ($days) {
                $q->where('ngay_nhap', '>=', now()->subDays($days));
            })
            ->whereDoesntHave('phieuXuat', function ($q) use ($days) {
                $q->where('ngay_xuat', '>=', now()->subDays($days));
            })
            ->whereDoesntHave('phieuChuyenKhoNguon', function ($q) use ($days) {
                $q->where('ngay_chuyen', '>=', now()->subDays($days));
            })
            ->whereDoesntHave('phieuChuyenKhoDich', function ($q) use ($days) {
                $q->where('ngay_chuyen', '>=', now()->subDays($days));
            })
            ->get();

        if ($request->has('export')) {
            return Excel::download(new HangTonDongExport($days, $ma_kho), 'bao_cao_hang_ton_dong_' . $ma_kho . '.xlsx');
        }

        return view('baocaokho.hang_ton_dong', compact('khoHang', 'tonKho', 'days'));
    }

    // Báo cáo chuyển kho
    public function chuyenKho(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $queryChuyenDi = PhieuChuyenKho::with(['sanPham', 'khoNguon', 'khoDich', 'nhanVien'])
            ->where('ma_kho_nguon', $ma_kho);
        if ($startDate && $endDate) {
            $queryChuyenDi->whereBetween('ngay_chuyen', [$startDate, $endDate]);
        }
        $chuyenDi = $queryChuyenDi->get();

        $queryChuyenDen = PhieuChuyenKho::with(['sanPham', 'khoNguon', 'khoDich', 'nhanVien'])
            ->where('ma_kho_dich', $ma_kho);
        if ($startDate && $endDate) {
            $queryChuyenDen->whereBetween('ngay_chuyen', [$startDate, $endDate]);
        }
        $chuyenDen = $queryChuyenDen->get();

        if ($request->has('export')) {
            return Excel::download(new ChuyenKhoExport($startDate, $endDate, $ma_kho), 'bao_cao_chuyen_kho_' . $ma_kho . '.xlsx');
        }

        return view('baocaokho.chuyen_kho', compact('khoHang', 'chuyenDi', 'chuyenDen', 'startDate', 'endDate'));
    }

    // Báo cáo chi kho
    public function chiKho(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = PhieuNhap::with('sanPham', 'khoHang')
            ->where('ma_kho', $ma_kho)
            ->whereNotNull('gia_nhap');
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_nhap', [$startDate, $endDate]);
        }
        $chiKho = $query->get();

        if ($request->has('export')) {
            return Excel::download(new ChiKhoExport($startDate, $endDate, $ma_kho), 'bao_cao_chi_kho_' . $ma_kho . '.xlsx');
        }

        return view('baocaokho.chi_kho', compact('khoHang', 'chiKho', 'startDate', 'endDate'));
    }

    // Báo cáo vốn kho
    public function Vonkho(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;
        $Von = Von::where('ma_kho', $ma_kho)->firstOrFail();
        $vonKho = $Von->tong_von;
        $ngayCapNhat = $Von->ngay_cap_nhat;

        if ($request->has('export') && $request->export === 'excel') {
            return Excel::download(new VonKhoExport(), 'bao_cao_von_kho_' . now()->format('Ymd_His') . '.xlsx');
        }

        return view('baocaokho.von_kho', compact('khoHang', 'vonKho', 'ngayCapNhat'));
    }
}