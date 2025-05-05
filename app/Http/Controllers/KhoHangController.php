<?php

namespace App\Http\Controllers;

use App\Models\KhoHang;
use App\Models\ChiTietKhoHang;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KhoHangController extends Controller
{
    public function index(Request $request)
    {
        $sortColumn = $request->get('sort', 'ma_kho');
        $sortDirection = $request->get('direction', 'asc');
        $search = $request->get('search');

        $query = KhoHang::with('nhanVien')->withCount('chiTietKhoHang as so_luong_sp');

        if ($search) {
            $query->where('ma_kho', 'like', "%{$search}%")
                  ->orWhere('ten_kho', 'like', "%{$search}%")
                  ->orWhereHas('nhanVien', function ($q) use ($search) {
                      $q->where('ten_nv', 'like', "%{$search}%");
                  });
        }

        $khoHangs = $query->orderBy($sortColumn, $sortDirection)->paginate(10);
        $chiTietKhoHangs = ChiTietKhoHang::whereIn('ma_kho', $khoHangs->pluck('ma_kho'))->get();

        if (!auth('admin')->check()) {
            abort(404, 'NOT FOUND');
        }

        return view('khohang.index', compact('khoHangs', 'chiTietKhoHangs', 'sortColumn', 'sortDirection', 'search'));
    }

    public function create()
    {
        if (!auth('admin')->check()) {
            abort(404, 'NOT FOUND');
        }

        $availableNhanVien = NhanVien::where('chuc_vu', 'Nhân viên kho')
            ->whereDoesntHave('khoHangs')
            ->get();
        return view('khohang.create', compact('availableNhanVien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_kho' => 'required|string|max:12|unique:kho_hang',
            'ten_kho' => 'required|string|max:30',
            'ma_nv' => 'required|exists:nhan_vien,ma_nv',
        ]);

        $nhanVien = NhanVien::find($request->ma_nv);
        if ($nhanVien->chuc_vu !== 'Nhân viên kho' || $nhanVien->khoHangs->count() > 0) {
            return back()->withErrors(['ma_nv' => 'Nhân viên không hợp lệ hoặc đã quản lý kho khác.']);
        }

        KhoHang::create($request->all());
        return redirect()->route('kho-hang.index')->with('success', 'Thêm kho hàng thành công!');
    }

    public function edit($ma_kho)
    {
        $khoHang = KhoHang::findOrFail($ma_kho);
        $availableNhanVien = NhanVien::where('chuc_vu', 'Nhân viên kho')
            ->where(function ($query) use ($khoHang) {
                $query->whereDoesntHave('khoHangs')
                      ->orWhere('ma_nv', $khoHang->ma_nv);
            })->get();
        return view('khohang.edit', compact('khoHang', 'availableNhanVien'));
    }

    public function update(Request $request, $ma_kho)
    {
        $request->validate([
            'ma_kho' => 'required|string|max:12|unique:kho_hang,ma_kho,' . $ma_kho . ',ma_kho',
            'ten_kho' => 'required|string|max:30',
            'ma_nv' => 'required|exists:nhan_vien,ma_nv',
        ]);

        $nhanVien = NhanVien::find($request->ma_nv);
        if ($nhanVien->chuc_vu !== 'Nhân viên kho' || ($nhanVien->khoHangs->count() > 0 && $nhanVien->ma_nv !== $ma_kho)) {
            return back()->withErrors(['ma_nv' => 'Nhân viên không hợp lệ hoặc đã quản lý kho khác.']);
        }

        DB::transaction(function () use ($request, $ma_kho) {
            DB::table('kho_hang')
            ->where('ma_kho', $ma_kho)
            ->update([
                'ma_kho' => $request->ma_kho,
                'ten_kho' => $request->ten_kho,
                'ma_nv' => $request->ma_nv,
            ]);
        });
        return redirect()->route('kho-hang.index')->with('success', 'Cập nhật kho hàng thành công!');
    }

    public function show(Request $request, $ma_kho)
    {
        $khoHang = KhoHang::with('nhanVien')->findOrFail($ma_kho);

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

        return view('khohang.show', compact('khoHang', 'chiTietKhoHangs', 'sortColumn', 'sortDirection', 'search'));
    }

    public function destroy($ma_kho)
    {
        $khoHang = KhoHang::findOrFail($ma_kho);
        $khoHang->delete();

        return redirect()->route('kho-hang.index')->with('success', 'Xóa kho hàng thành công!');
    }
}