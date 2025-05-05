<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\LoaiSP;
use App\Models\CuaHang;
use App\Models\KhoHang;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    public function index(Request $request)
    {
        $sortColumn = $request->get('sort', 'ma_sp');
        $sortDirection = $request->get('direction', 'asc');
        $search = $request->get('search');

        $query = SanPham::with('loaiSP');

        if ($search) {
            $query->where('ma_sp', 'like', "%{$search}%")
                ->orWhere('ten_sp', 'like', "%{$search}%")
                ->orWhere('loai_sp', 'like', "%{$search}%");
        }

        $sanPhams = $query->orderBy($sortColumn, $sortDirection)->paginate(10);

        foreach ($sanPhams as $sanPham) {
            $sanPham->so_luong = $sanPham->chiTietKhoHang()->sum('so_luong');
        }

        if (!auth('admin')->check()) {
            abort(404, 'NOT FOUND');
        }
        
        return view('sanpham.index', compact('sanPhams', 'sortColumn', 'sortDirection', 'search'));
    }

    public function create()
    {
        if (!auth('admin')->check()) {
            abort(404, 'NOT FOUND');
        }

        $loaiSPs = LoaiSP::all();
        return view('sanpham.create', compact('loaiSPs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_sp' => 'required|string|max:8|unique:san_pham',
            'ten_sp' => 'required|string|max:50',
            'don_vi_tinh' => 'required|string|max:10',
            'gia_nhap' => 'required|numeric|min:0',
            'ban_buon' => 'required|numeric|min:0',
            'ban_le' => 'required|numeric|min:0',
            'loai_sp' => 'required|exists:loai_sp,loai_sp',
        ]);

        SanPham::create(array_merge($request->all(), ['so_luong' => 0]));
        return redirect()->route('san-pham.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function show($ma_sp)
    {
        $sanPham = SanPham::findOrFail($ma_sp);
        $sanPham->so_luong = $sanPham->chiTietKhoHang()->sum('so_luong');
        return view('sanpham.show', compact('sanPham'));
    }

    public function admin_store_show($ma_cua_hang, $ma_sp)
    {
        $sanPham = SanPham::findOrFail($ma_sp);
        $cuaHang = CuaHang::where('ma_cua_hang', $ma_cua_hang)->first();
        $sanPham->so_luong = $sanPham->chiTietCuaHang()
            ->where('ma_cua_hang', $ma_cua_hang)
            ->sum('so_luong');
        return view('sanpham.admin_store_show', compact('sanPham', 'ma_cua_hang', 'cuaHang'));
    }

    public function admin_warehouse_show($ma_kho, $ma_sp)
    {
        $sanPham = SanPham::findOrFail($ma_sp);
        $khoHang = KhoHang::where('ma_kho', $ma_kho)->first();
        $sanPham->so_luong = $sanPham->chiTietKhoHang()
            ->where('ma_kho', $ma_kho)
            ->sum('so_luong');
        return view('sanpham.admin_warehouse_show', compact('sanPham', 'ma_kho', 'khoHang'));
    }

    public function staff_store_show($ma_cua_hang, $ma_sp)
    {
        $sanPham = SanPham::findOrFail($ma_sp);
        $cuaHang = CuaHang::where('ma_cua_hang', $ma_cua_hang)->first();
        $sanPham->so_luong = $sanPham->chiTietCuaHang()
            ->where('ma_cua_hang', $ma_cua_hang)
            ->sum('so_luong');
        return view('sanpham.staff_store_show', compact('sanPham', 'ma_cua_hang', 'cuaHang'));
    }

    public function staff_warehouse_show($ma_kho, $ma_sp)
    {
        $sanPham = SanPham::findOrFail($ma_sp);
        $khoHang = KhoHang::where('ma_kho', $ma_kho)->first();
        $sanPham->so_luong = $sanPham->chiTietKhoHang()
            ->where('ma_kho', $ma_kho)
            ->sum('so_luong');
        return view('sanpham.staff_warehouse_show', compact('sanPham', 'ma_kho', 'khoHang'));
    }

    public function edit($ma_sp)
    {
        $sanPham = SanPham::findOrFail($ma_sp);
        $loaiSPs = LoaiSP::all();
        $sanPham->so_luong = $sanPham->chiTietKhoHang()->sum('so_luong');
        return view('sanpham.edit', compact('sanPham', 'loaiSPs'));
    }

    public function update(Request $request, $ma_sp)
    {
        $request->validate([
            'ten_sp' => 'required|string|max:50',
            'don_vi_tinh' => 'required|string|max:10',
            'gia_nhap' => 'required|numeric|min:0',
            'ban_buon' => 'required|numeric|min:0',
            'ban_le' => 'required|numeric|min:0',
            'loai_sp' => 'required|string|exists:loai_sp,loai_sp',
        ]);

        $sanPham = SanPham::findOrFail($ma_sp);
        $sanPham->update($request->all());
        return redirect()->route('san-pham.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy($ma_sp)
    {
        $sanPham = SanPham::findOrFail($ma_sp);
        $sanPham->delete();
        return redirect()->route('san-pham.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}