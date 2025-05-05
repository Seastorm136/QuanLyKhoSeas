<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use App\Models\CuaHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HoaDonController extends Controller
{
    public function index(Request $request)
    {
        $sortColumn = $request->get('sort', 'ma_hoa_don');
        $sortDirection = $request->get('direction', 'asc');
        $search = $request->get('search');

        $query = HoaDon::with('nhanVien');
        if ($search) {
            $query->where('ma_hoa_don', 'like', "%{$search}%")
                  ->orWhere('ngay_lap', 'like', "%{$search}%")
                  ->orWhereHas('nhanVien', function ($q) use ($search) {
                      $q->where('ten_nv', 'like', "%{$search}%");
                  });
        }

        $hoaDons = $query->orderBy($sortColumn, $sortDirection)->paginate(10);

        return view('hoadon.index', compact('hoaDons', 'sortColumn', 'sortDirection', 'search'));
    }

    public function staff_index(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();

        $query = HoaDon::where('ma_nv', $ma_nv);
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('ma_hoa_don', 'like', "%{$search}%")
                  ->orWhere('ngay_lap', 'like', "%{$search}%");
            });
        }

        $sortColumn = $request->input('sort', 'ma_hoa_don');
        $sortDirection = $request->input('direction', 'asc');
        $hoaDons = $query->orderBy($sortColumn, $sortDirection)->paginate(10);

        return view('hoadon.staff_index', compact('hoaDons', 'cuaHang', 'sortColumn', 'sortDirection'));
    }

    public function create()
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_cua_hang = $cuaHang->ma_cua_hang;

        $sanPhams = SanPham::select('san_pham.*')
        ->leftJoin('chi_tiet_cua_hang', function ($join) use ($ma_cua_hang) {
            $join->on('san_pham.ma_sp', '=', 'chi_tiet_cua_hang.ma_sp')
                 ->where('chi_tiet_cua_hang.ma_cua_hang', '=', $ma_cua_hang);
        })
        ->where('chi_tiet_cua_hang.so_luong', '>', 0)
        ->with(['chiTietCuaHang' => function ($query) use ($ma_cua_hang) {
            $query->where('ma_cua_hang', $ma_cua_hang);
        }])
        ->get();

        return view('hoadon.create', compact('sanPhams', 'cuaHang'));
    }

    public function store(Request $request)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_cua_hang = $cuaHang->ma_cua_hang;

        $request->validate([
            'ngay_lap' => 'required|date',
            'ma_nv' => 'required|exists:nhan_vien,ma_nv',
            'products' => 'required|array',
            'products.*.ma_sp' => 'required|exists:san_pham,ma_sp',
            'products.*.loai_gia' => 'required|in:ban_buon,ban_le',
            'products.*.so_luong' => 'required|integer|min:1',
            'products.*.don_gia' => 'required|numeric|min:0',
            'products.*.thanh_tien' => 'required|numeric|min:0',
        ]);

        $today = now()->format('Ymd');
        $lastHoaDon = HoaDon::where('ma_hoa_don', 'like', "HD-$today%")
            ->orderBy('ma_hoa_don', 'desc')
            ->first();
        $stt = $lastHoaDon ? (int)substr($lastHoaDon->ma_hoa_don, -3) + 1 : 1;
        $maHoaDon = "HD-$today-" . str_pad($stt, 3, '0', STR_PAD_LEFT);

        DB::beginTransaction();
        try {
            DB::table('hoa_don')->insert([
                'ma_hoa_don' => $maHoaDon,
                'ngay_lap' => $request->ngay_lap,
                'ma_nv' => $request->ma_nv,
                'tong_tien' => 0,
            ]);

            $tongTien = 0;
            foreach ($request->products as $product) {
                $sanPham = DB::table('san_pham')
                    ->where('ma_sp', $product['ma_sp'])
                    ->first();

                if (!$sanPham) {
                    throw new \Exception("Sản phẩm {$product['ma_sp']} không tồn tại.");
                }

                $donGia = $product['loai_gia'] === 'ban_buon' ? $sanPham->ban_buon : $sanPham->ban_le;
                if ($donGia != $product['don_gia']) {
                    throw new \Exception("Đơn giá không hợp lệ cho sản phẩm {$product['ma_sp']}.");
                }

                $chiTietCH = DB::table('chi_tiet_cua_hang')
                    ->where('ma_cua_hang', $ma_cua_hang)
                    ->where('ma_sp', $product['ma_sp'])
                    ->first();

                if (!$chiTietCH || $chiTietCH->so_luong < $product['so_luong']) {
                    throw new \Exception("Số lượng tồn kho không đủ cho sản phẩm {$product['ma_sp']}.");
                }

                DB::table('chi_tiet_hoa_don')->insert([
                    'ma_hoa_don' => $maHoaDon,
                    'ma_sp' => $product['ma_sp'],
                    'so_luong' => $product['so_luong'],
                    'don_gia' => $product['don_gia'],
                    'thanh_tien' => $product['thanh_tien'],
                ]);

                DB::table('chi_tiet_cua_hang')
                    ->where('ma_cua_hang', $ma_cua_hang)
                    ->where('ma_sp', $product['ma_sp'])
                    ->update([
                        'so_luong' => $chiTietCH->so_luong - $product['so_luong'],
                    ]);

                $tongTien += $product['thanh_tien'];
            }

            DB::table('hoa_don')
                ->where('ma_hoa_don', $maHoaDon)
                ->update(['tong_tien' => $tongTien]);

            DB::commit();
            return redirect()->route('hoa-don.staff_index')->with('success', 'Thêm hóa đơn thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Không thể thêm hóa đơn: ' . $e->getMessage()]);
        }
    }

    public function show($ma_hoa_don)
    {
        $hoaDon = HoaDon::with('nhanVien', 'chiTietHoaDons.sanPham')->findOrFail($ma_hoa_don);
        return view('hoadon.show', compact('hoaDon'));
    }

    public function staff_show($ma_hoa_don)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
    
        $hoaDon = HoaDon::where('ma_nv', $ma_nv)
                        ->where('ma_hoa_don', $ma_hoa_don)
                        ->with('nhanVien', 'chiTietHoaDons.sanPham')
                        ->firstOrFail();
    
        return view('hoadon.staff_show', compact('hoaDon'));
    }

    public function edit($ma_hoa_don)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $hoaDon = HoaDon::with('chiTietHoaDons')->findOrFail($ma_hoa_don);
        
        $cuaHang = CuaHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_cua_hang = $cuaHang->ma_cua_hang;

        $sanPhams = SanPham::select('san_pham.*')
            ->leftJoin('chi_tiet_cua_hang', function ($join) use ($ma_cua_hang) {
                $join->on('san_pham.ma_sp', '=', 'chi_tiet_cua_hang.ma_sp')
                    ->where('chi_tiet_cua_hang.ma_cua_hang', '=', $ma_cua_hang);
            })
            ->where('chi_tiet_cua_hang.so_luong', '>', 0)
            ->with(['chiTietCuaHang' => function ($query) use ($ma_cua_hang) {
                $query->where('ma_cua_hang', $ma_cua_hang);
            }])
            ->get();

        return view('hoadon.edit', compact('hoaDon', 'sanPhams', 'cuaHang'));
    }

    public function update(Request $request, $ma_hoa_don)
    {
        $request->validate([
            'ngay_lap' => 'required|date',
            'ma_nv' => 'required|exists:nhan_vien,ma_nv',
            'products' => 'required|array',
            'products.*.ma_sp' => 'required|exists:san_pham,ma_sp',
            'products.*.loai_gia' => 'required|in:ban_buon,ban_le',
            'products.*.so_luong' => 'required|integer|min:1',
            'products.*.don_gia' => 'required|numeric|min:0',
            'products.*.thanh_tien' => 'required|numeric|min:0',
        ]);

        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_cua_hang = CuaHang::where('ma_nv', $nhanVien->ma_nv)->firstOrFail()->ma_cua_hang;
    
        DB::beginTransaction();
        try {
            $hoaDon = DB::table('hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->first();

            if (!$hoaDon) {
                throw new \Exception("Hóa đơn {$ma_hoa_don} không tồn tại.");
            }

            $oldChiTiets = DB::table('chi_tiet_hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->get()
                ->keyBy('ma_sp');

            DB::table('hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->update([
                    'ngay_lap' => $request->ngay_lap,
                    'ma_nv' => $request->ma_nv,
                    'tong_tien' => 0,
                ]);

            $tongTien = 0;
            $newChiTiets = [];

            foreach ($request->products as $product) {
                $ma_sp = $product['ma_sp'];
                $newSoLuong = (int) $product['so_luong'];
                $loaiGia = $product['loai_gia'];

                $sanPham = DB::table('san_pham')
                    ->where('ma_sp', $ma_sp)
                    ->first();

                if (!$sanPham) {
                    throw new \Exception("Sản phẩm {$ma_sp} không tồn tại.");
                }

                $donGia = $loaiGia === 'ban_buon' ? $sanPham->ban_buon : $sanPham->ban_le;
                if ($donGia != $product['don_gia']) {
                    throw new \Exception("Đơn giá không hợp lệ cho sản phẩm {$ma_sp}.");
                }

                $thanhTien = $newSoLuong * $donGia;
                if ($thanhTien != $product['thanh_tien']) {
                    throw new \Exception("Thành tiền không hợp lệ cho sản phẩm {$ma_sp}.");
                }

                $chiTietCH = DB::table('chi_tiet_cua_hang')
                    ->where('ma_cua_hang', $ma_cua_hang)
                    ->where('ma_sp', $ma_sp)
                    ->first();

                if (!$chiTietCH) {
                    throw new \Exception("Sản phẩm {$ma_sp} không có trong kho cửa hàng {$ma_cua_hang}.");
                }

                $oldSoLuong = isset($oldChiTiets[$ma_sp]) ? (int) $oldChiTiets[$ma_sp]->so_luong : 0;
                $deltaSoLuong = $newSoLuong - $oldSoLuong;

                if ($deltaSoLuong > 0) {
                    if ($chiTietCH->so_luong < $deltaSoLuong) {
                        throw new \Exception("Số lượng tồn kho không đủ cho sản phẩm {$ma_sp}. Còn lại: {$chiTietCH->so_luong}.");
                    }
                }

                $newTonKho = $chiTietCH->so_luong - $deltaSoLuong;
                if ($newTonKho < 0) {
                    throw new \Exception("Tồn kho không thể âm cho sản phẩm {$ma_sp}.");
                }

                DB::table('chi_tiet_cua_hang')
                    ->where('ma_cua_hang', $ma_cua_hang)
                    ->where('ma_sp', $ma_sp)
                    ->update([
                        'so_luong' => $newTonKho,
                    ]);

                $newChiTiets[] = [
                    'ma_hoa_don' => $ma_hoa_don,
                    'ma_sp' => $ma_sp,
                    'so_luong' => $newSoLuong,
                    'don_gia' => $donGia,
                    'thanh_tien' => $thanhTien,
                ];

                $tongTien += $thanhTien;
            }

            DB::table('chi_tiet_hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->delete();

            if (!empty($newChiTiets)) {
                DB::table('chi_tiet_hoa_don')->insert($newChiTiets);
            }

            DB::table('hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->update(['tong_tien' => $tongTien]);

            DB::commit();
            return redirect()->route('hoa-don.staff_index')->with('success', 'Cập nhật hóa đơn thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Không thể cập nhật hóa đơn: ' . $e->getMessage()]);
        }
    }

    public function destroy($ma_hoa_don)
    {
        DB::beginTransaction();
        try {
            $hoaDon = DB::table('hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->first();

            if (!$hoaDon) {
                throw new \Exception("Hóa đơn {$ma_hoa_don} không tồn tại.");
            }

            $chiTiets = DB::table('chi_tiet_hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->get();

            foreach ($chiTiets as $chiTiet) {
                $chiTietCH = DB::table('chi_tiet_cua_hang')
                    ->where('ma_cua_hang', $hoaDon->ma_nv)
                    ->where('ma_sp', $chiTiet->ma_sp)
                    ->first();

                if ($chiTietCH) {
                    DB::table('chi_tiet_cua_hang')
                        ->where('ma_cua_hang', $hoaDon->ma_nv)
                        ->where('ma_sp', $chiTiet->ma_sp)
                        ->update([
                            'so_luong' => $chiTietCH->so_luong + $chiTiet->so_luong,
                        ]);
                }
            }

            DB::table('chi_tiet_hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->delete();

            DB::table('hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->delete();

            DB::commit();
            return redirect()->route('hoa-don.index')->with('success', 'Xóa hóa đơn thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Không thể xóa hóa đơn: ' . $e->getMessage()]);
        }
    }

    public function staff_destroy($ma_hoa_don)
    {
        $nhanVien = auth('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;

        DB::beginTransaction();
        try {
            $hoaDon = DB::table('hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->where('ma_nv', $ma_nv)
                ->first();

            if (!$hoaDon) {
                throw new \Exception("Hóa đơn {$ma_hoa_don} không tồn tại hoặc không thuộc nhân viên.");
            }

            $chiTiets = DB::table('chi_tiet_hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->get();

            foreach ($chiTiets as $chiTiet) {
                $chiTietCH = DB::table('chi_tiet_cua_hang')
                    ->where('ma_cua_hang', $hoaDon->ma_nv)
                    ->where('ma_sp', $chiTiet->ma_sp)
                    ->first();

                if ($chiTietCH) {
                    DB::table('chi_tiet_cua_hang')
                        ->where('ma_cua_hang', $hoaDon->ma_nv)
                        ->where('ma_sp', $chiTiet->ma_sp)
                        ->update([
                            'so_luong' => $chiTietCH->so_luong + $chiTiet->so_luong,
                        ]);
                }
            }

            DB::table('chi_tiet_hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->delete();

            DB::table('hoa_don')
                ->where('ma_hoa_don', $ma_hoa_don)
                ->delete();

            DB::commit();
            return redirect()->route('hoa-don.staff_index')->with('success', 'Xóa hóa đơn thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Không thể xóa hóa đơn: ' . $e->getMessage()]);
        }
    }
}