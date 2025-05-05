<?php

namespace App\Exports;

use App\Models\PhieuNhapCuaHang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminNhapCuaHangExport implements FromCollection, WithHeadings
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
        $query = PhieuNhapCuaHang::with('sanPham', 'cuaHang');
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_nhap', [$this->startDate, $this->endDate]);
        }
        return $query->get()->map(function ($phieu) {
            return [
                'ma_phieu_nhap_ch' => $phieu->ma_phieu_nhap_ch,
                'ngay_nhap' => $phieu->ngay_nhap,
                'ten_cua_hang' => $phieu->cuaHang->ten_cua_hang,
                'ten_sp' => $phieu->sanPham->ten_sp,
                'so_luong_nhap' => $phieu->so_luong_nhap,
            ];
        });
    }

    public function headings(): array
    {
        return ['Mã phiếu nhập', 'Ngày nhập', 'Cửa hàng', 'Sản phẩm', 'Số lượng nhập'];
    }
}

class NhapCuaHangExport implements FromCollection, WithHeadings, WithMapping
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
        $query = PhieuNhapCuaHang::with('sanPham', 'khoHang')
            ->where('ma_cua_hang', $this->maCuaHang);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_xuat', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Mã phiếu nhập cửa hàng',
            'Ngày nhập',
            'Sản phẩm',
            'Số lượng nhập',
        ];
    }

    public function map($phieu): array
    {
        return [
            $phieu->ma_phieu_nhap_ch,
            $phieu->ngay_nhap,
            $phieu->sanPham->ten_sp,
            $phieu->so_luong_nhap,
        ];
    }
}