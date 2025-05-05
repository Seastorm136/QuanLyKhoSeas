<?php

namespace App\Http\Controllers;

use App\Models\ChiTietKhoHang;
use App\Models\KhoHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChiTietKhoHangController extends Controller
{
    public function index(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        $sortColumn = $request->get('sort', 'ma_sp');
        $sortDirection = $request->get('direction', 'asc');
        $search = $request->get('search');

        $query = ChiTietKhoHang::with('sanPham')->where('ma_kho', $ma_kho);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ma_sp', 'like', "%{$search}%")
                  ->orWhereHas('sanPham', function ($q) use ($search) {
                      $q->where('ten_sp', 'like', "%{$search}%")
                        ->orWhere('loai_sp', 'like', "%{$search}%");
                  });
            });
        }

        $chiTietKhoHangs = $query->orderBy($sortColumn, $sortDirection)->paginate(10);

        return view('chitietkhohang.index', compact('khoHang', 'chiTietKhoHangs', 'sortColumn', 'sortDirection', 'search'));
    }
    
    public function create($ma_kho)
    {
        $khoHang = KhoHang::findOrFail($ma_kho);
        $sanPhams = SanPham::all();
        return view('chitietkhohang.create', compact('khoHang', 'sanPhams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_kho' => 'required|exists:kho_hang,ma_kho',
            'ma_sp' => 'required|exists:san_pham,ma_sp|unique:chi_tiet_kho_hang,ma_sp,NULL,ma_sp,ma_kho,' . $request->ma_kho,
            'so_luong' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $chiTiet = ChiTietKhoHang::create([
                'ma_kho' => $request->ma_kho,
                'ma_sp' => $request->ma_sp,
                'so_luong' => $request->so_luong,
                'loai_sp' => SanPham::find($request->ma_sp)->loai_sp,
            ]);
        });

        return redirect()->route('kho-hang.show', $request->ma_kho)->with('success', 'Thêm chi tiết kho thành công!');
    }

    public function edit($ma_kho, $ma_sp)
    {
        $chiTiet = ChiTietKhoHang::where('ma_kho', $ma_kho)->where('ma_sp', $ma_sp)->firstOrFail();
        return view('chitietkhohang.edit', compact('chiTiet'));
    }

    public function update(Request $request, $ma_kho, $ma_sp)
    {
        $request->validate([
            'so_luong' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request, $ma_kho, $ma_sp) {
            DB::table('chi_tiet_kho_hang')
            ->where('ma_kho', $ma_kho)
            ->where('ma_sp', $ma_sp)
            ->update([
                'so_luong' => (int)$request->so_luong,
            ]);
        });

        return redirect()->route('kho-hang.show', $ma_kho)->with('success', 'Cập nhật sản phẩn trong kho thành công!');
    }

    public function destroy($ma_kho, $ma_sp)
    {
        DB::transaction(function () use ($ma_kho, $ma_sp) {
            DB::table('chi_tiet_kho_hang')
            ->where('ma_kho', $ma_kho)
            ->where('ma_sp', $ma_sp)
            ->delete();
        });

        return redirect()->route('kho-hang.show', $ma_kho)->with('success', 'Xóa sản phẩm thành công!');
    }
}