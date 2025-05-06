<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\LoaiSPController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\KhoHangController;
use App\Http\Controllers\ChiTietKhoHangController;
use App\Http\Controllers\CuaHangController;
use App\Http\Controllers\ChiTietCuaHangController;
use App\Http\Controllers\HoaDonController;
use App\Http\Controllers\PhieuNhapController;
use App\Http\Controllers\PhieuXuatController;
use App\Http\Controllers\PhieuChuyenKhoController;
use App\Http\Controllers\PhieuNhapCuaHangController;
use App\Http\Controllers\BaoCaoController;
use App\Http\Controllers\BaoCaoCuaHangController;
use App\Http\Controllers\BaoCaoKhoController;
use App\Http\Controllers\TaoPhieuController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::prefix('password')->group(function () {
        Route::get('/change', [PasswordController::class, 'adminChange'])->name('password.admin_change');
        Route::put('/update', [PasswordController::class, 'adminUpdate'])->name('password.admin_update');
    });
    Route::prefix('nhan-vien')->group(function () {
        Route::get('/index', [NhanVienController::class, 'index'])->name('nhan-vien.index');
        Route::get('/create', [NhanVienController::class, 'create'])->name('nhan-vien.create');
        Route::get('/edit/{ma_nv}', [NhanVienController::class, 'edit'])->name('nhan-vien.edit');
        Route::get('/show/{ma_nv}', [NhanVienController::class, 'show'])->name('nhan-vien.show');
        Route::delete('/destroy/{ma_nv}', [NhanVienController::class, 'destroy'])->name('nhan-vien.destroy');
        Route::post('/store', [NhanVienController::class, 'store'])->name('nhan-vien.store');
        Route::put('/update/{ma_nv}', [NhanVienController::class, 'update'])->name('nhan-vien.update');
    });
    Route::prefix('san-pham')->group(function () {
        Route::get('/index', [SanPhamController::class, 'index'])->name('san-pham.index');
        Route::get('/create', [SanPhamController::class, 'create'])->name('san-pham.create');
        Route::get('/edit/{ma_sp}', [SanPhamController::class, 'edit'])->name('san-pham.edit');
        Route::get('/show/{ma_sp}', [SanPhamController::class, 'show'])->name('san-pham.show');
        Route::delete('/destroy/ma_sp}', [SanPhamController::class, 'destroy'])->name('san-pham.destroy');
        Route::get('/show-kho/{ma_kho}/{ma_sp}', [SanPhamController::class, 'admin_warehouse_show'])->name('san-pham.admin_warehouse_show');
        Route::get('/show-cua-hang/{ma_cua_hang}/{ma_sp}', [SanPhamController::class, 'admin_store_show'])->name('san-pham.admin_store_show');
        Route::post('/store', [SanPhamController::class, 'store'])->name('san-pham.store');
        Route::put('/update/{ma_sp}', [SanPhamController::class, 'update'])->name('san-pham.update');
    });
    Route::prefix('loai-sp')->group(function () {
        Route::get('/index', [LoaiSPController::class, 'index'])->name('loai-sp.index');
        Route::get('/create', [LoaiSPController::class, 'create'])->name('loai-sp.create');
        Route::get('/edit/{loai_sp}', [LoaiSPController::class, 'edit'])->name('loai-sp.edit');
        Route::get('/show/{loai_sp}', [LoaiSPController::class, 'show'])->name('loai-sp.show');
        Route::delete('/destroy/{loai_sp}', [LoaiSPController::class, 'destroy'])->name('loai-sp.destroy');
        Route::post('/store', [LoaiSPController::class, 'store'])->name('loai-sp.store');
        Route::put('/update/{loai_sp}', [LoaiSPController::class, 'update'])->name('loai-sp.update');
    });
    Route::prefix('kho-hang')->group(function () {
        Route::get('/index', [KhoHangController::class, 'index'])->name('kho-hang.index');
        Route::get('/create', [KhoHangController::class, 'create'])->name('kho-hang.create');
        Route::get('/show/{ma_kho}', [KhoHangController::class, 'show'])->name('kho-hang.show');
        Route::get('/edit/{ma_kho}', [KhoHangController::class, 'edit'])->name('kho-hang.edit');
        Route::delete('/destroy/{ma_kho}', [KhoHangController::class, 'destroy'])->name('kho-hang.destroy');
        Route::post('/store', [KhoHangController::class, 'store'])->name('kho-hang.store');
        Route::put('/update/{ma_kho}', [KhoHangController::class, 'update'])->name('kho-hang.update');
    });
    Route::prefix('cua-hang')->group(function () {
        Route::get('/index', [CuaHangController::class, 'index'])->name('cua-hang.index');
        Route::get('/create', [CuaHangController::class, 'create'])->name('cua-hang.create');
        Route::get('/show/{ma_cua_hang}', [CuaHangController::class, 'show'])->name('cua-hang.show');
        Route::get('/edit/{ma_cua_hang}', [CuaHangController::class, 'edit'])->name('cua-hang.edit');
        Route::delete('/destroy/{ma_cua_hang}', [CuaHangController::class, 'destroy'])->name('cua-hang.destroy');
        Route::post('/store', [CuaHangController::class, 'store'])->name('cua-hang.store');
        Route::put('/update/{ma_cua_hang}', [CuaHangController::class, 'update'])->name('cua-hang.update');
    });
    Route::prefix('chi-tiet-kho-hang')->group(function () {
        Route::get('/create/{ma_kho}', [ChiTietKhoHangController::class, 'create'])->name('chi-tiet-kho-hang.create');
        Route::get('/edit/{ma_kho}/{ma_sp}', [ChiTietKhoHangController::class, 'edit'])->name('chi-tiet-kho-hang.edit');
        Route::put('/update/{ma_kho}/{ma_sp}', [ChiTietKhoHangController::class, 'update'])->name('chi-tiet-kho-hang.update');
        Route::delete('/destroy/{ma_kho}/{ma_sp}', [ChiTietKhoHangController::class, 'destroy'])->name('chi-tiet-kho-hang.destroy');
        Route::post('/store', [ChiTietKhoHangController::class, 'store'])->name('chi-tiet-kho-hang.store');
    });
    Route::prefix('chi-tiet-cua-hang')->group(function () {
        Route::get('/create/{ma_cua_hang}', [ChiTietCuaHangController::class, 'create'])->name('chi-tiet-cua-hang.create');
        Route::get('/edit/{ma_cua_hang}/{ma_sp}', [ChiTietCuaHangController::class, 'edit'])->name('chi-tiet-cua-hang.edit');
        Route::put('/update/{ma_cua_hang}/{ma_sp}', [ChiTietCuaHangController::class, 'update'])->name('chi-tiet-cua-hang.update');
        Route::delete('/destroy/{ma_cua_hang}/{ma_sp}', [ChiTietCuaHangController::class, 'destroy'])->name('chi-tiet-cua-hang.destroy');
        Route::post('/store', [ChiTietCuaHangController::class, 'store'])->name('chi-tiet-cua-hang.store');
    });
    Route::prefix('hoa-don')->group(function () {
        Route::get('/index', [HoaDonController::class, 'index'])->name('hoa-don.index');
        Route::get('/show/{ma_hoa_don}', [HoaDonController::class, 'show'])->name('hoa-don.show');
        Route::delete('/destroy/{ma_hoa_don}', [HoaDonController::class, 'destroy'])->name('hoa-don.destroy');
    });
    Route::prefix('bao-cao')->group(function () {
        Route::get('/index', [BaoCaoController::class, 'index'])->name('bao-cao.index');
        Route::get('/nhap-kho', [BaoCaoController::class, 'nhapKho'])->name('bao-cao.nhap_kho');
        Route::get('/xuat-kho', [BaoCaoController::class, 'xuatKho'])->name('bao-cao.xuat_kho');
        Route::get('/ton-kho', [BaoCaoController::class, 'tonKho'])->name('bao-cao.ton_kho');
        Route::get('/hang-ton-dong', [BaoCaoController::class, 'hangTonDong'])->name('bao-cao.hang_ton_dong');
        Route::get('/chuyen-kho', [BaoCaoController::class, 'chuyenKho'])->name('bao-cao.chuyen_kho');
        Route::get('/chi-kho', [BaoCaoController::class, 'chiKho'])->name('bao-cao.chi_kho');
        Route::get('/nhap-cua-hang', [BaoCaoController::class, 'nhapCuaHang'])->name('bao-cao.nhap_cua_hang');
        Route::get('/ban-hang', [BaoCaoController::class, 'banHang'])->name('bao-cao.ban_hang');
        Route::get('/thu-cua-hang', [BaoCaoController::class, 'thuCuaHang'])->name('bao-cao.thu_cua_hang');
        Route::get('/tong-von', [BaoCaoController::class, 'tongVon'])->name('bao-cao.tong_von');
        Route::post('/them-von', [BaoCaoController::class, 'themVon'])->name('bao-cao.them_von');
        Route::post('/phan-phoi-von', [BaoCaoController::class, 'phanPhoiVon'])->name('bao-cao.phan_phoi_von');
        Route::post('/rut-von', [BaoCaoController::class, 'rutVon'])->name('bao-cao.rut_von');
    });
});

Route::prefix('staff')->middleware('auth:staff')->group(function () {
    Route::get('/home-warehouse', function () { return view('home_warehouse'); })->name('home_warehouse');
    Route::get('/home-store', function () { return view('home_store'); })->name('home_store');
    Route::prefix('password')->group(function () {
        Route::get('/warehouse/change', [PasswordController::class, 'staffWarehouseChange'])->name('password.staff_warehouse_change');
        Route::put('/warehouse/update', [PasswordController::class, 'staffWarehouseUpdate'])->name('password.staff_warehouse_update');
        Route::get('/store/change', [PasswordController::class, 'staffStoreChange'])->name('password.staff_store_change');
        Route::put('/store/update', [PasswordController::class, 'staffStoreUpdate'])->name('password.staff_store_update');
    });
    Route::prefix('nhan-vien')->group(function () {
        Route::get('/information', [NhanVienController::class, 'staffIndex'])->name('nhan-vien.staff_index');
        Route::get('/edit', [NhanVienController::class, 'staffEdit'])->name('nhan-vien.staff_edit');
        Route::put('/update', [NhanVienController::class, 'staffUpdate'])->name('nhan-vien.staff_update');
    });
    Route::prefix('san-pham')->group(function () {
        Route::get('/show-cua-hang/{ma_cua_hang}/{ma_sp}', [SanPhamController::class, 'staff_store_show'])->name('san-pham.staff_store_show');
        Route::get('/show-kho/{ma_kho}/{ma_sp}', [SanPhamController::class, 'staff_warehouse_show'])->name('san-pham.staff_warehouse_show');
    });
    Route::get('/chi-tiet-kho-hang', [ChiTietKhoHangController::class, 'index'])->name('chi-tiet-kho-hang.index');
    Route::get('/chi-tiet-cua-hang', [ChiTietCuaHangController::class, 'index'])->name('chi-tiet-cua-hang.index');
    Route::prefix('hoa-don')->group(function () {
        Route::get('/index', [HoaDonController::class, 'staff_index'])->name('hoa-don.staff_index');
        Route::get('/create', [HoaDonController::class, 'create'])->name('hoa-don.create');
        Route::get('/show/{ma_hoa_don}', [HoaDonController::class, 'staff_show'])->name('hoa-don.staff_show');
        Route::get('/edit/{ma_hoa_don}', [HoaDonController::class, 'edit'])->name('hoa-don.edit');
        Route::delete('/destroy/{ma_hoa_don}', [HoaDonController::class, 'staff_destroy'])->name('hoa-don.staff_destroy');
        Route::put('/update/{ma_hoa_don}', [HoaDonController::class, 'update'])->name('hoa-don.update');
        Route::post('/store', [HoaDonController::class, 'store'])->name('hoa-don.store');
    });
    Route::prefix('bao-cao-kho')->group(function () {
        Route::get('/index', [BaoCaoKhoController::class, 'index'])->name('bao-cao-kho.index');
        Route::get('/nhap-kho', [BaoCaoKhoController::class, 'nhapKho'])->name('bao-cao-kho.nhap_kho');
        Route::get('/xuat-kho', [BaoCaoKhoController::class, 'xuatKho'])->name('bao-cao-kho.xuat_kho');
        Route::get('/ton-kho', [BaoCaoKhoController::class, 'tonKho'])->name('bao-cao-kho.ton_kho');
        Route::get('/hang-ton-dong', [BaoCaoKhoController::class, 'hangTonDong'])->name('bao-cao-kho.hang_ton_dong');
        Route::get('/chuyen-kho', [BaoCaoKhoController::class, 'chuyenKho'])->name('bao-cao-kho.chuyen_kho');
        Route::get('/chi-kho', [BaoCaoKhoController::class, 'chiKho'])->name('bao-cao-kho.chi_kho');
        Route::get('/von-kho', [BaoCaoKhoController::class, 'vonKho'])->name('bao-cao-kho.von_kho');
    });
    
    Route::prefix('/bao-cao-cua-hang')->group(function () { 
        Route::get('/index' , [BaoCaoCuaHangController::class, 'index'])->name('bao-cao-cua-hang.index');
        Route::get('/nhap-cua-hang', [BaoCaoCuaHangController::class, 'nhapCuaHang'])->name('bao-cao-cua-hang.nhap_cua_hang');
        Route::get('/ban-hang', [BaoCaoCuaHangController::class, 'banHang'])->name('bao-cao-cua-hang.ban_hang');
        Route::get('/thu-cua-hang', [BaoCaoCuaHangController::class, 'thuCuaHang'])->name('bao-cao-cua-hang.thu_cua_hang');
    });
    
    Route::prefix('phieu-nhap')->group(function () {
        Route::get('/create', [PhieuNhapController::class, 'create'])->name('phieu-nhap.create');
        Route::post('/store', [PhieuNhapController::class, 'store'])->name('phieu-nhap.store');
    });
    
    Route::prefix('phieu-xuat')->group(function () {
        Route::get('/create', [PhieuXuatController::class, 'create'])->name('phieu-xuat.create');
        Route::post('/store', [PhieuXuatController::class, 'store'])->name('phieu-xuat.store');
    });
    
    Route::prefix('phieu-chuyen-kho')->group(function () {
        Route::get('/index', [PhieuChuyenKhoController::class, 'index'])->name('phieu-chuyen-kho.create_index');
        Route::get('/create/chuyen-den', [PhieuChuyenKhoController::class, 'create_den'])->name('phieu-chuyen-kho.create_den');
        Route::post('/store/chuyen-den', [PhieuChuyenKhoController::class, 'store_den'])->name('phieu-chuyen-kho.store_den');
        Route::get('/create/chuyen-di', [PhieuChuyenKhoController::class, 'create_di'])->name('phieu-chuyen-kho.create_di');
        Route::post('/store/chuyen-di', [PhieuChuyenKhoController::class, 'store_di'])->name('phieu-chuyen-kho.store_di');
    });
    
    Route::prefix('phieu-nhap-cua-hang')->group(function () {
        Route::get('/create', [PhieuNhapCuaHangController::class, 'create'])->name('phieu-nhap-cua-hang.create');
        Route::post('/store', [PhieuNhapCuaHangController::class, 'store'])->name('phieu-nhap-cua-hang.store');
    });
    
    Route::prefix('tao-phieu')->group(function () {
        Route::get('/warehouse-index', [TaoPhieuController::class, 'warehouseIndex'])->name('tao-phieu.warehouse_index');
        Route::get('/store-index', [TaoPhieuController::class, 'storeIndex'])->name('tao-phieu.store_index');
    });
});

