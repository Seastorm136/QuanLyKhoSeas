<?php

namespace App\Http\Controllers;

use App\Models\StaffLogin;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NhanVienController extends Controller
{
    public function index(Request $request)
    {
        $sortColumn = $request->get('sort', 'ma_nv');
        $sortDirection = $request->get('direction', 'asc');
        $search = $request->get('search');

        $query = NhanVien::query();

        if ($search) {
            $query->where('ma_nv', 'like', "%{$search}%")
                ->orWhere('ten_nv', 'like', "%{$search}%")
                ->orWhere('so_dt', 'like', "%{$search}%");
        }

        $nhanViens = $query->orderBy($sortColumn, $sortDirection)->paginate(10);

        return view('nhanvien.index', compact('nhanViens', 'sortColumn', 'sortDirection', 'search'));
    }

    public function staffIndex()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        return view('nhanvien.staff_index', compact('nhanVien'));
    }

    public function create()
    {   
        return view('nhanvien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_nv' => 'required|string|max:15|unique:nhan_vien,ma_nv',
            'ten_nv' => 'required|string|max:20',
            'gioitinh' => 'required|in:Nam,Nữ',
            'ngay_sinh' => 'required|date',
            'so_dt' => 'required|string|max:10|unique:nhan_vien,so_dt|regex:/^[0-9]{10}$/',
            'dia_chi' => 'required|string|max:100',
            'chuc_vu' => 'required|in:Nhân viên kho,Nhân viên bán hàng',
            'ten_tknh' => 'required|string|max:50',
            'so_tknh' => 'required|string|max:10|unique:nhan_vien,so_tknh|regex:/^[0-9]{10}$/',
            'ten_dn' => 'required|string|max:30|unique:nhan_vien,ten_dn|unique:staff_login,staff_name',
            'password' => 'required|string|min:6',
        ]);

        DB::transaction(function () use ($request) {
            StaffLogin::create([
                'staff_name' => $request->ten_dn,
                'password' => Hash::make($request->password),
            ]);

            NhanVien::create([
                'ma_nv' => $request->ma_nv,
                'ten_nv' => $request->ten_nv,
                'gioitinh' => $request->gioitinh,
                'ngay_sinh' => $request->ngay_sinh,
                'so_dt' => $request->so_dt,
                'dia_chi' => $request->dia_chi,
                'chuc_vu' => $request->chuc_vu,
                'ten_tknh' => $request->ten_tknh,
                'so_tknh' => $request->so_tknh,
                'ten_dn' => $request->ten_dn,
            ]);
        });

        return redirect()->route('nhan-vien.index')->with('success', 'Thêm nhân viên thành công!');
    }

    public function show($ma_nv)
    {
        $nhanVien = NhanVien::findOrFail($ma_nv);
        return view('nhanvien.show', compact('nhanVien'));
    }

    public function edit($ma_nv)
    {
        $nhanVien = NhanVien::findOrFail($ma_nv);
        return view('nhanvien.edit', compact('nhanVien'));
    }

    public function staffEdit()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        return view('nhanvien.staff_edit', compact('nhanVien'));
    }

    public function update(Request $request, $ma_nv)
    {
        $request->validate([
            'ten_nv' => 'required|string|max:20',
            'gioitinh' => 'required|in:Nam,Nữ',
            'ngay_sinh' => 'required|date',
            'so_dt' => 'required|string|max:10|unique:nhan_vien,so_dt,' . $ma_nv . ',ma_nv',
            'dia_chi' => 'required|string|max:100',
            'chuc_vu' => 'required|in:Nhân viên kho,Nhân viên bán hàng',
            'ten_tknh' => 'required|string|max:50',
            'so_tknh' => 'required|string|max:10|unique:nhan_vien,so_tknh,' . $ma_nv . ',ma_nv',
        ]);

        $nhanVien = NhanVien::findOrFail($ma_nv);
        $nhanVien->update($request->all());
        return redirect()->route('nhan-vien.index')->with('success', 'Cập nhật nhân viên thành công!');
    }

    public function staffUpdate(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;

        $request->validate([
            'ten_nv' => 'required|string|max:20',
            'gioitinh' => 'required|in:Nam,Nữ',
            'ngay_sinh' => 'required|date',
            'so_dt' => 'required|string|max:10|unique:nhan_vien,so_dt,' . $ma_nv . ',ma_nv',
            'dia_chi' => 'required|string|max:100',
            'chuc_vu' => 'required|in:Nhân viên kho,Nhân viên bán hàng',
            'ten_tknh' => 'required|string|max:50',
            'so_tknh' => 'required|string|max:10|unique:nhan_vien,so_tknh,' . $ma_nv . ',ma_nv',
            'ten_dn' => 'required|string|max:30|unique:nhan_vien,ten_dn,' . $ma_nv . ',ma_nv|exists:staff_login,staff_name',
        ]);
        
        $nhanVien->update($request->all());
        return redirect()->route('nhan-vien.index')->with('success', 'Cập nhật nhân viên thành công!');
    }

    public function destroy($ma_nv)
    {
        DB::transaction(function () use ($ma_nv) {
            $nhanVien = NhanVien::findOrFail($ma_nv);

            if ($nhanVien->cuaHang || $nhanVien->khoHang) {
                throw new \Exception('Nhân viên đang quản lý cửa hàng hoặc kho hàng, không thể xóa.');
            }

            $nhanVien->delete();
        });
        return redirect()->route('nhan-vien.index')->with('success', 'Xóa nhân viên thành công!');
    }
}