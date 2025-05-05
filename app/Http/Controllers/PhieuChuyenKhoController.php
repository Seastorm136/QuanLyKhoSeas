<?php

namespace App\Http\Controllers;

use App\Models\PhieuChuyenKho;
use App\Models\KhoHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhieuChuyenKhoController extends Controller
{

    public function index()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        return view('phieuchuyenkho.create_index', compact('nhanVien'));
    }

    public function create_den()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHangDich = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho_dich = $khoHangDich->ma_kho;

        $khoHangs = KhoHang::where('ma_kho', '!=', $ma_kho_dich)->get();

        $chiTietKho = DB::table('chi_tiet_kho_hang')->where('ma_kho', $ma_kho_dich)->get();
        $sanPhams = SanPham::whereIn('ma_sp', $chiTietKho->pluck('ma_sp'))
            ->get()
            ->map(function ($sanPham) use ($chiTietKho) {
                $sanPham->so_luong_ton = $chiTietKho->firstWhere('ma_sp', $sanPham->ma_sp)->so_luong ?? 0;
                return $sanPham;
            });

        return view('phieuchuyenkho.create_den', compact('khoHangs', 'sanPhams', 'nhanVien', 'khoHangDich'));
    }

    public function create_di()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHangNguon = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho_nguon = $khoHangNguon->ma_kho;

        $khoHangs = KhoHang::where('ma_kho', '!=', $ma_kho_nguon)->get();

        $chiTietKho = DB::table('chi_tiet_kho_hang')->where('ma_kho', $ma_kho_nguon)->get();
        $sanPhams = SanPham::whereIn('ma_sp', $chiTietKho->pluck('ma_sp'))
            ->get()
            ->map(function ($sanPham) use ($chiTietKho) {
                $sanPham->so_luong_ton = $chiTietKho->firstWhere('ma_sp', $sanPham->ma_sp)->so_luong ?? 0;
                return $sanPham;
            });

        return view('phieuchuyenkho.create_di', compact('khoHangs', 'sanPhams', 'nhanVien', 'khoHangNguon'));
    }

    public function store_den(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHangDich = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho_dich = $khoHangDich->ma_kho;

        $request->validate([
            'ngay_chuyen' => 'required|date',
            'ma_kho_nguon' => "required|exists:kho_hang,ma_kho|different:ma_kho_dich",
            'ma_sp' => 'required|exists:san_pham,ma_sp',
            'so_luong_chuyen_den' => 'required|integer|min:1',
            'ma_nv' => 'required|exists:nhan_vien,ma_nv',
        ]);

        $today = now()->format('Ymd');
        $lastPhieu = PhieuChuyenKho::where('ma_phieu_chuyen', 'like', "PC-$today%")
            ->orderBy('ma_phieu_chuyen', 'desc')
            ->first();
        $stt = $lastPhieu ? (int)substr($lastPhieu->ma_phieu_chuyen, -3) + 1 : 1;
        $maPhieuChuyen = "PC-$today-" . str_pad($stt, 3, '0', STR_PAD_LEFT);

        $chiTietKhoDich = DB::table('chi_tiet_kho_hang')
            ->where('ma_kho', $ma_kho_dich)
            ->where('ma_sp', $request->ma_sp)
            ->first();
        
        $phieuChuyen = PhieuChuyenKho::create([
            'ma_phieu_chuyen' => $maPhieuChuyen,
            'ngay_chuyen' => $request->ngay_chuyen,
            'ma_kho_nguon' => $request->ma_kho_nguon,
            'ma_kho_dich' => $ma_kho_dich,
            'ma_sp' => $request->ma_sp,
            'so_luong_chuyen_den' => $request->so_luong_chuyen_den,
            'ma_nv' => $request->ma_nv,
        ]);

        DB::table('chi_tiet_kho_hang')
            ->where('ma_kho', $request->ma_kho_dich)
            ->where('ma_sp', $request->ma_sp)
            ->increment('so_luong', (int)$request->so_luong_chuyen_den);

        return redirect()->route('tao-phieu.warehouse_index')->with('success', 'Thêm phiếu chuyển đến thành công!');
    }

    public function store_di(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHangNguon = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho_nguon = $khoHangNguon->ma_kho;

        $request->validate([
            'ngay_chuyen' => 'required|date',
            'ma_kho_dich' => "required|exists:kho_hang,ma_kho|different:ma_kho_nguon",
            'ma_sp' => 'required|exists:san_pham,ma_sp',
            'so_luong_chuyen_di' => 'required|integer|min:1',
            'ma_nv' => 'required|exists:nhan_vien,ma_nv',
        ]);

        $today = now()->format('Ymd');
        $lastPhieu = PhieuChuyenKho::where('ma_phieu_chuyen', 'like', "PC-$today%")
            ->orderBy('ma_phieu_chuyen', 'desc')
            ->first();
        $stt = $lastPhieu ? (int)substr($lastPhieu->ma_phieu_chuyen, -3) + 1 : 1;
        $maPhieuChuyen = "PC-$today-" . str_pad($stt, 3, '0', STR_PAD_LEFT);

        $chiTietKhoNguon = DB::table('chi_tiet_kho_hang')
            ->where('ma_kho', $ma_kho_nguon)
            ->where('ma_sp', $request->ma_sp)
            ->first();

        if (!$chiTietKhoNguon || $chiTietKhoNguon->so_luong < $request->so_luong_chuyen_di) {
            return back()->withErrors(['so_luong_chuyen_di' => 'Số lượng tồn kho nguồn không đủ để chuyển!']);
        }

        $phieuChuyen = PhieuChuyenKho::create([
            'ma_phieu_chuyen' => $maPhieuChuyen,
            'ngay_chuyen' => $request->ngay_chuyen,
            'ma_kho_nguon' => $ma_kho_nguon,
            'ma_kho_dich' => $request->ma_kho_dich,
            'ma_sp' => $request->ma_sp,
            'so_luong_chuyen_di' => $request->so_luong_chuyen_di,
            'ma_nv' => $request->ma_nv,
        ]);

        DB::table('chi_tiet_kho_hang')
            ->where('ma_kho', $ma_kho_nguon)
            ->where('ma_sp', $request->ma_sp)
            ->decrement('so_luong', (int)$request->so_luong_chuyen_di);

        return redirect()->route('tao-phieu.warehouse_index')->with('success', 'Thêm phiếu chuyển đi thành công!');
    }
}