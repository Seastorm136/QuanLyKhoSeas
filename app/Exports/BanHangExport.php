<?php

namespace App\Exports;

use App\Models\HoaDon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminBanHangExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = HoaDon::with('chiTietHoaDons.sanPham');
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_lap', [$this->startDate, $this->endDate]);
        }
        $hoaDons = $query->get();
        $data = collect();
        foreach ($hoaDons as $hoaDon) {
            foreach ($hoaDon->chiTietHoaDons as $chiTiet) {
                $data->push([
                    'ma_hoa_don' => $hoaDon->ma_hoa_don,
                    'ngay_lap' => $hoaDon->ngay_lap,
                    'ten_sp' => $chiTiet->sanPham->ten_sp,
                    'so_luong' => $chiTiet->so_luong,
                    'don_gia' => $chiTiet->don_gia,
                    'thanh_tien' => $chiTiet->thanh_tien,
                ]);
            }
        }
        return $data;
    }

    public function headings(): array
    {
        return ['Mã hóa đơn', 'Ngày lập', 'Sản phẩm', 'Số lượng', 'Đơn giá', 'Thành tiền'];
    }
}

class BanHangExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
    protected $maCuaHang;

    public function __construct($startDate, $endDate, $maCuaHang)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->maCuaHang = $maCuaHang;
    }

    public function collection()
    {
        $query = HoaDon::with('chiTietHoaDons.sanPham')
            ->where('ma_cua_hang', $this->maCuaHang);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_lap', [$this->startDate, $this->endDate]);
        }
        $hoaDons = $query->get();
        $data = collect();
        foreach ($hoaDons as $hoaDon) {
            foreach ($hoaDon->chiTietHoaDons as $chiTiet) {
                $data->push([
                    $hoaDon->ma_hoa_don,
                    $hoaDon->ngay_lap,
                    $chiTiet->sanPham->ten_sp,
                    $chiTiet->so_luong,
                    $chiTiet->don_gia,
                    $chiTiet->thanh_tien,
                ]);
            }
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'Mã hóa đơn',
            'Ngày lập', 
            'Sản phẩm', 
            'Số lượng', 
            'Đơn giá', 
            'Thành tiền',
        ];
    }
}