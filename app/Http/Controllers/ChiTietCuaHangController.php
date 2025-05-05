<?php

namespace App\Http\Controllers;

use App\Models\ChiTietCuaHang;
use App\Models\CuaHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChiTietCuaHangController extends Controller
{
    public function index(Request $request)
{
    $nhanVien = auth('staff')->user()->nhanVien;
    $ma_nv = $nhanVien->ma_nv;
    $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();
    $ma_cua_hang = $cuaHang->ma_cua_hang;

    $sortColumn = $request->get('sort', 'ma_sp');
    $sortDirection = $request->get('direction', 'asc');
    $search = $request->get('search');

    $query = ChiTietCuaHang::with('sanPham')->where('ma_cua_hang', $ma_cua_hang);

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('ma_sp', 'like', "%{$search}%")
              ->orWhereHas('sanPham', function ($q) use ($search) {
                  $q->where('ten_sp', 'like', "%{$search}%");
              });
        });
    }

    $chiTietCuaHangs = $query->orderBy($sortColumn, $sortDirection)->paginate(10);

    return view('chitietcuahang.index', compact('chiTietCuaHangs', 'cuaHang', 'sortColumn', 'sortDirection', 'search'));
}

    public function create($ma_cua_hang)
    {
        $cuaHang = CuaHang::findOrFail($ma_cua_hang);
        $sanPhams = SanPham::all();
        return view('chitietcuahang.create', compact('cuaHang', 'sanPhams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_cua_hang' => 'required|exists:cua_hang,ma_cua_hang',
            'ma_sp' => 'required|exists:san_pham,ma_sp|unique:chi_tiet_cua_hang,ma_sp,NULL,ma_sp,ma_cua_hang,' . $request->ma_cua_hang,
            'so_luong' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $chiTiet = ChiTietCuaHang::create([
                'ma_cua_hang' => $request->ma_cua_hang,
                'ma_sp' => $request->ma_sp,
                'so_luong' => $request->so_luong,
            ]);
        });

        return redirect()->route('cua-hang.show', $request->ma_cua_hang)->with('success', 'Thêm chi tiết cửa hàng thành công!');
    }

    public function edit($ma_cua_hang, $ma_sp)
    {
        $chiTiet = ChiTietCuaHang::where('ma_cua_hang', $ma_cua_hang)->where('ma_sp', $ma_sp)->firstOrFail();
        return view('chitietcuahang.edit', compact('chiTiet'));
    }

    public function update(Request $request, $ma_cua_hang, $ma_sp)
    {
        $request->validate([
            'so_luong' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request, $ma_cua_hang, $ma_sp) {
            DB::table('chi_tiet_cua_hang')
            ->where('ma_cua_hang', $ma_cua_hang)
            ->where('ma_sp', $ma_sp)
            ->update([
                'so_luong' => (int)$request->so_luong,
            ]);
        });

        return redirect()->route('cua-hang.show', $ma_cua_hang)->with('success', 'Cập nhật sản phẩm trong cửa hàng thành công!');
    }

    public function destroy($ma_cua_hang, $ma_sp)
    {
        DB::transaction(function () use ($ma_cua_hang, $ma_sp) {
            DB::table('chi_tiet_cua_hang')
            ->where('ma_cua_hang', $ma_cua_hang)
            ->where('ma_sp', $ma_sp)
            ->delete();
        });

        return redirect()->route('cua-hang.show', $ma_cua_hang)->with('success', 'Xóa sản phẩm thành công!');
    }
}