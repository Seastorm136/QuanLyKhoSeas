<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->only(['adminChange', 'adminUpdate']);
        $this->middleware('auth:staff')->only([
            'staffWarehouseChange', 'staffWarehouseUpdate',
            'staffStoreChange', 'staffStoreUpdate'
        ]);
    }

    public function adminChange()
    {
        return view('password.admin_change');
    }

    public function adminUpdate(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password:admin'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = Auth::guard('admin')->user();
        $hashedPassword = Hash::make($request->password);

        DB::table('admin_login')
            ->where('admin_name', $user->admin_name)
            ->update(['password' => $hashedPassword]);

        return redirect()->route('dashboard')->with('success', 'Đổi mật khẩu thành công!');
    }

    public function staffWarehouseChange()
    {
        $user = Auth::guard('staff')->user();
        $nhanVien = $user->nhanVien;

        if (!$nhanVien || $nhanVien->chuc_vu !== 'Nhân viên kho') {
            return redirect()->route('home_warehouse')->withErrors(['error' => 'Bạn không có quyền truy cập trang này.']);
        }

        return view('password.staff_warehouse_change');
    }

    public function staffWarehouseUpdate(Request $request)
    {
        $user = Auth::guard('staff')->user();
        $nhanVien = $user->nhanVien;

        if (!$nhanVien || $nhanVien->chuc_vu !== 'Nhân viên kho') {
            return redirect()->route('home_warehouse')->withErrors(['error' => 'Bạn không có quyền truy cập trang này.']);
        }

        $request->validate([
            'current_password' => ['required', 'current_password:staff'],
            'password' => ['required', 'confirmed'],
        ]);

        $hashedPassword = Hash::make($request->password);

        DB::table('staff_login')
            ->where('staff_name', $user->staff_name)
            ->update(['password' => $hashedPassword]);

        return redirect()->route('home_warehouse')->with('success', 'Đổi mật khẩu thành công!');
    }

    public function staffStoreChange()
    {
        $user = Auth::guard('staff')->user();
        $nhanVien = $user->nhanVien;

        if (!$nhanVien || $nhanVien->chuc_vu !== 'Nhân viên bán hàng') {
            return redirect()->route('home_store')->withErrors(['error' => 'Bạn không có quyền truy cập trang này.']);
        }

        return view('password.staff_store_change');
    }

    public function staffStoreUpdate(Request $request)
    {
        $user = Auth::guard('staff')->user();
        $nhanVien = $user->nhanVien;

        if (!$nhanVien || $nhanVien->chuc_vu !== 'Nhân viên bán hàng') {
            return redirect()->route('home_store')->withErrors(['error' => 'Bạn không có quyền truy cập trang này.']);
        }

        $request->validate([
            'current_password' => ['required', 'current_password:staff'],
            'password' => ['required', 'confirmed'],
        ]);

        $hashedPassword = Hash::make($request->password);

        DB::table('staff_login')
            ->where('staff_name', $user->staff_name)
            ->update(['password' => $hashedPassword]);

        return redirect()->route('home_store')->with('success', 'Đổi mật khẩu thành công!');
    }
}