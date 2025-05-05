<?php

namespace App\Http\Controllers;

use App\Models\PhieuNhap;
use App\Models\PhieuXuat;
use App\Models\PhieuChuyenKho;
use App\Models\PhieuNhapCuaHang;
use App\Models\HoaDon;
use App\Models\ChiTietKhoHang;
use App\Models\Von;
use App\Models\VonLuuDong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminNhapKhoExport;
use App\Exports\AdminXuatKhoExport;
use App\Exports\AdminTonKhoExport;
use App\Exports\AdminHangTonDongExport;
use App\Exports\AdminChuyenKhoExport;
use App\Exports\AdminChiKhoExport;
use App\Exports\AdminNhapCuaHangExport;
use App\Exports\AdminBanHangExport;
use App\Exports\AdminThuCuaHangExport;
use App\Exports\AdminTongVonExport;

class BaoCaoController extends Controller
{
    public function index()
    {
        return view('baocao.index');
    }
    // Báo cáo nhập kho
    public function nhapKho(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = PhieuNhap::with('sanPham', 'khoHang');
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_nhap', [$startDate, $endDate]);
        }
        $nhapKho = $query->get();

        if ($request->has('export')) {
            return Excel::download(new AdminNhapKhoExport($startDate, $endDate), 'bao_cao_nhap_kho.xlsx');
        }

        return view('baocao.nhap_kho', compact('nhapKho', 'startDate', 'endDate'));
    }

    // Báo cáo xuất kho
    public function xuatKho(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = PhieuXuat::with('sanPham', 'khoHang');
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_xuat', [$startDate, $endDate]);
        }
        $xuatKho = $query->get();

        if ($request->has('export')) {
            return Excel::download(new AdminXuatKhoExport($startDate, $endDate), 'bao_cao_xuat_kho.xlsx');
        }

        return view('baocao.xuat_kho', compact('xuatKho', 'startDate', 'endDate'));
    }

    // Báo cáo tồn kho
    public function tonKho(Request $request)
    {
        $tonKho = ChiTietKhoHang::with('sanPham', 'khoHang')->get();

        if ($request->has('export')) {
            return Excel::download(new AdminTonKhoExport, 'bao_cao_ton_kho.xlsx');
        }

        return view('baocao.ton_kho', compact('tonKho'));
    }

    // Báo cáo hàng tồn đọng
    public function hangTonDong(Request $request)
    {
        $days = $request->input('days', 30);
        $tonKho = ChiTietKhoHang::with('sanPham', 'khoHang')
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
            return Excel::download(new AdminHangTonDongExport($days), 'bao_cao_hang_ton_dong.xlsx');
        }

        return view('baocao.hang_ton_dong', compact('tonKho', 'days'));
    }

    // Báo cáo chuyển kho
    public function chuyenKho(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = PhieuChuyenKho::with('sanPham', 'khoNguon', 'khoDich');
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_chuyen', [$startDate, $endDate]);
        }
        $chuyenKho = $query->get();

        if ($request->has('export')) {
            return Excel::download(new AdminChuyenKhoExport($startDate, $endDate), 'bao_cao_chuyen_kho.xlsx');
        }

        return view('baocao.chuyen_kho', compact('chuyenKho', 'startDate', 'endDate'));
    }

    // Báo cáo chi kho
    public function chiKho(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = PhieuNhap::with('sanPham', 'khoHang');
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_nhap', [$startDate, $endDate]);
        }
        $chiKho = $query->get();

        if ($request->has('export')) {
            return Excel::download(new AdminChiKhoExport($startDate, $endDate), 'bao_cao_chi_kho.xlsx');
        }

        return view('baocao.chi_kho', compact('chiKho', 'startDate', 'endDate'));
    }

    // Báo cáo nhập cửa hàng
    public function nhapCuaHang(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = PhieuNhapCuaHang::with('sanPham', 'cuaHang');
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_nhap', [$startDate, $endDate]);
        }
        $nhapCuaHang = $query->get();

        if ($request->has('export')) {
            return Excel::download(new AdminNhapCuaHangExport($startDate, $endDate), 'bao_cao_nhap_cua_hang.xlsx');
        }

        return view('baocao.nhap_cua_hang', compact('nhapCuaHang', 'startDate', 'endDate'));
    }

    // Báo cáo bán hàng
    public function banHang(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = HoaDon::with('chiTietHoaDons.sanPham');
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_lap', [$startDate, $endDate]);
        }
        $banHang = $query->get();

        if ($request->has('export')) {
            return Excel::download(new AdminBanHangExport($startDate, $endDate), 'bao_cao_ban_hang.xlsx');
        }

        return view('baocao.ban_hang', compact('banHang', 'startDate', 'endDate'));
    }

    // Báo cáo thu cửa hàng
    public function thuCuaHang(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = HoaDon::with('nhanVien');
        if ($startDate && $endDate) {
            $query->whereBetween('ngay_lap', [$startDate, $endDate]);
        }
        $thuCuaHang = $query->get();

        if ($request->has('export')) {
            return Excel::download(new AdminThuCuaHangExport($startDate, $endDate), 'bao_cao_thu_cua_hang.xlsx');
        }

        return view('baocao.thu_cua_hang', compact('thuCuaHang', 'startDate', 'endDate'));
    }

    // Báo cáo tổng vốn
    public function tongVon(Request $request)
    {
        $tongVonKho = Von::sum('tong_von');

        $vonLuuDong = VonLuuDong::firstOrCreate([], ['tong_von_luu_dong' => 0, 'ngay_cap_nhat' => now()]);
        $tongVonLuuDong = $vonLuuDong->tong_von_luu_dong;

        $thangTruoc = now()->subMonth()->startOfMonth();
        $cuoiThangTruoc = now()->subMonth()->endOfMonth();
        $doanhThuBanHang = HoaDon::whereBetween('ngay_lap', [$thangTruoc, $cuoiThangTruoc])->sum('tong_tien');

        $tongVon = $tongVonLuuDong + $tongVonKho;

        $danhSachVon = Von::with('kho')->get();

        if ($request->has('export')) {
            return Excel::download(new AdminTongVonExport(), 'bao_cao_tong_von.xlsx');
        }

        return view('baocao.tong_von', compact('tongVon', 'danhSachVon', 'doanhThuBanHang', 'tongVonKho', 'tongVonLuuDong'));
    }

    public function themVon(Request $request)
    {
        $request->validate([
            'tong_von' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $vonLuuDong = VonLuuDong::firstOrCreate([], ['tong_von_luu_dong' => 0, 'ngay_cap_nhat' => now()]);
            $vonLuuDong->tong_von_luu_dong += $request->tong_von;
            $vonLuuDong->ngay_cap_nhat = now();
            $vonLuuDong->save();

            DB::commit();
            return redirect()->route('bao-cao.tong_von')->with('success', 'Thêm vốn ban đầu vào vốn lưu động thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('bao-cao.tong_von')->with('error', 'Thêm vốn thất bại: ' . $e->getMessage());
        }
    }

    public function phanPhoiVon(Request $request)
    {
        $request->validate([
            'ma_kho' => 'required|exists:kho_hang,ma_kho',
            'so_tien_phan_phoi' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $vonLuuDong = VonLuuDong::first();
            if (!$vonLuuDong || $vonLuuDong->tong_von_luu_dong < $request->so_tien_phan_phoi) {
                throw new \Exception('Vốn lưu động không đủ để phân phối.');
            }

            $vonLuuDong->tong_von_luu_dong -= $request->so_tien_phan_phoi;
            $vonLuuDong->ngay_cap_nhat = now();
            $vonLuuDong->save();

            $von = Von::firstOrCreate(
                ['ma_kho' => $request->ma_kho],
                ['tong_von' => 0, 'ngay_cap_nhat' => now()]
            );
            $von->tong_von += $request->so_tien_phan_phoi;
            $von->ngay_cap_nhat = now();
            $von->save();

            DB::commit();
            return redirect()->route('bao-cao.tong_von')->with('success', 'Phân phối vốn thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('bao-cao.tong_von')->with('error', 'Phân phối vốn thất bại: ' . $e->getMessage());
        }
    }

    public function rutVon(Request $request)
    {
        $request->validate([
            'ma_kho' => 'required|exists:kho_hang,ma_kho',
            'so_tien_rut' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $von = Von::where('ma_kho', $request->ma_kho)->first();
            if (!$von || $von->tong_von < $request->so_tien_rut) {
                throw new \Exception('Vốn kho không đủ để rút.');
            }

            $von->tong_von -= $request->so_tien_rut;
            $von->ngay_cap_nhat = now();
            $von->save();

            $vonLuuDong = VonLuuDong::firstOrCreate([], ['tong_von_luu_dong' => 0, 'ngay_cap_nhat' => now()]);
            $vonLuuDong->tong_von_luu_dong += $request->so_tien_rut;
            $vonLuuDong->ngay_cap_nhat = now();
            $vonLuuDong->save();

            DB::commit();
            return redirect()->route('bao-cao.tong_von')->with('success', 'Rút vốn về vốn lưu động thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('bao-cao.tong_von')->with('error', 'Rút vốn thất bại: ' . $e->getMessage());
        }
    }
}