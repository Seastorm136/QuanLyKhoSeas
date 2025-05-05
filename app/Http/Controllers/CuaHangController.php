<?php

namespace App\Http\Controllers;

use App\Models\CuaHang;
use App\Models\ChiTietCuaHang;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuaHangController extends Controller
{
    public function index(Request $request)
    {
        $sortColumn = $request->get('sort', 'ma_cua_hang');
        $sortDirection = $request->get('direction', 'asc');
        $search = $request->get('search');

        $query = CuaHang::with('nhanVien')->withCount('chiTietCuaHang as so_luong_sp');

        if ($search) {
            $query->where('ma_cua_hang', 'like', "%{$search}%")
                  ->orWhere('ten_cua_hang', 'like', "%{$search}%")
                  ->orWhereHas('nhanVien', function ($q) use ($search) {
                      $q->where('ten_nv', 'like', "%{$search}%");
                  });
        }
        
        if (!auth('admin')->check()) {
            abort(404, 'NOT FOUND');
        }

        $cuaHangs = $query->orderBy($sortColumn, $sortDirection)->paginate(10);
        $chiTietCuaHangs = ChiTietCuaHang::whereIn('ma_cua_hang', $cuaHangs->pluck('ma_cua_hang'))->get();

        return view('cuahang.index', compact('cuaHangs', 'chiTietCuaHangs', 'sortColumn', 'sortDirection', 'search'));
    }

    public function create()
    {
        if (!auth('admin')->check()) {
            abort(404, 'NOT FOUND');
        }
        
        $availableNhanVien = NhanVien::where('chuc_vu', 'Nhân viên bán hàng')
            ->whereDoesntHave('cuaHangs')
            ->get();
        return view('cuahang.create', compact('availableNhanVien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_cua_hang' => 'required|string|max:10|unique:cua_hang',
            'ten_cua_hang' => 'required|string|max:30',
            'ma_nv' => 'required|exists:nhan_vien,ma_nv',
        ]);

        $nhanVien = NhanVien::find($request->ma_nv);
        if ($nhanVien->chuc_vu !== 'Nhân viên bán hàng') {
            return back()->withErrors(['ma_nv' => 'Nhân viên phải có chức vụ "Nhân viên bán hàng".']);
        }

        CuaHang::create([
            'ma_cua_hang' => $request->ma_cua_hang,
            'ten_cua_hang' => $request->ten_cua_hang,
            'ma_nv' => $request->ma_nv,
        ]);

        return redirect()->route('cua-hang.index')->with('success', 'Thêm cửa hàng thành công!');
    }

    public function edit($ma_cua_hang)
    {
        $cuaHang = CuaHang::findOrFail($ma_cua_hang);
        $availableNhanVien = NhanVien::where('chuc_vu', 'Nhân viên bán hàng')
            ->where(function ($query) use ($cuaHang) {
                $query->whereDoesntHave('cuaHangs')
                      ->orWhere('ma_nv', $cuaHang->ma_nv);
            })->get();
        return view('cuahang.edit', compact('cuaHang', 'availableNhanVien'));
    }
    
    public function update(Request $request, $ma_cua_hang)
    {
        $request->validate([
            'ma_cua_hang' => 'required|string|max:10|unique:cua_hang,ma_cua_hang,' . $ma_cua_hang . ',ma_cua_hang',
            'ten_cua_hang' => 'required|string|max:30',
            'ma_nv' => 'required|exists:nhan_vien,ma_nv',
        ]);

        $nhanVien = NhanVien::find($request->ma_nv);
        if ($nhanVien->chuc_vu !== 'Nhân viên bán hàng') {
            return back()->withErrors(['ma_nv' => 'Nhân viên phải có chức vụ "Nhân viên bán hàng".']);
        }

        DB::transaction(function () use ($request, $ma_cua_hang) {
            DB::table('cua_hang')
            ->where('ma_cua_hang', $ma_cua_hang)
            ->update([
                'ma_cua_hang' => $request->ma_cua_hang,
                'ten_cua_hang' => $request->ten_cua_hang,
                'ma_nv' => $request->ma_nv,
            ]);
        });

        return redirect()->route('cua-hang.index')->with('success', 'Cập nhật cửa hàng thành công!');
    }

    public function show(Request $request, $ma_cua_hang)
    {
        $cuaHang = CuaHang::with('nhanVien')->findOrFail($ma_cua_hang);

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

        return view('cuahang.show', compact('cuaHang', 'chiTietCuaHangs', 'sortColumn', 'sortDirection', 'search'));
    }

    public function destroy($ma_cua_hang)
    {
        $cuaHang = CuaHang::findOrFail($ma_cua_hang);
        $cuaHang->delete();

        return redirect()->route('cua-hang.index')->with('success', 'Xóa cửa hàng thành công!');
    }
}