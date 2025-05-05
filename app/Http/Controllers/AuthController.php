<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'ten_dn' => 'required|string|max:30',
            'mat_khau' => 'required|string|min:6|max:255',
        ]);
        $credentials = [
            'staff_Name' => $request->input('ten_dn'),
            'password' => $request->input('mat_khau'),
        ];
        $adminCredentials = [
            'admin_Name' => $request->input('ten_dn'),
            'password' => $request->input('mat_khau'),
        ];
        $remember = $request->has('remember');

        if (Auth::guard('staff')->attempt($credentials, $remember)) {
            $user = Auth::guard('staff')->user();
            $nhanVien = $user->nhanVien;

            if ($nhanVien) {
                if ($nhanVien->chuc_vu === 'Nhân viên kho') {
                    return redirect()->route('home_warehouse');
                } elseif ($nhanVien->chuc_vu === 'Nhân viên bán hàng') {
                    return redirect()->route('home_store');
                }
            }

            Auth::guard('staff')->logout();
            return redirect('/login')->withErrors(['ten_dn' => 'Không tìm thấy thông tin nhân viên']);
        }

        if (Auth::guard('admin')->attempt($adminCredentials, $remember)) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['ten_dn' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('staff')->check()) {
            Auth::guard('staff')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        return redirect('/login');
    }

}