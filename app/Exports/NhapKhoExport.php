<?php

namespace App\Exports;

use App\Models\PhieuNhap;
use App\Models\ChiTietKhoHang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminNhapKhoExport implements FromCollection, WithHeadings
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
        $query = PhieuNhap::with('sanPham', 'khoHang');
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_nhap', [$this->startDate, $this->endDate]);
        }
        return $query->get()->map(function ($phieu) {
            return [
                'ma_phieu_nhap' => $phieu->ma_phieu_nhap,
                'ngay_nhap' => $phieu->ngay_nhap,
                'ten_kho' => $phieu->khoHang->ten_kho,
                'ten_sp' => $phieu->sanPham->ten_sp,
                'so_luong_nhap' => $phieu->so_luong_nhap,
                'gia_nhap' => $phieu->gia_nhap,
                'tong_chi' => $phieu->so_luong_nhap * $phieu->gia_nhap,
            ];
        });
    }

    public function headings(): array
    {
        return ['Mã phiếu nhập', 'Ngày nhập', 'Kho', 'Sản phẩm', 'Số lượng', 'Giá nhập', 'Tổng chi'];
    }
}

class NhapKhoExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;
    protected $maKho;

    public function __construct($startDate, $endDate, $maKho)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->maKho = $maKho;
    }

    public function collection()
    {
        $sanPhamTrongKho = ChiTietKhoHang::where('ma_kho', $this->maKho)->pluck('ma_sp')->toArray();

        $query = PhieuNhap::with('sanPham', 'khoHang')
            ->where('ma_kho', $this->maKho)
            ->whereIn('ma_sp', $sanPhamTrongKho);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_nhap', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Mã phiếu nhập',
            'Ngày nhập',
            'Sản phẩm',
            'Số lượng',
            'Giá nhập',
            'Tổng chi',
        ];
    }

    public function map($phieu): array
    {
        return [
            $phieu->ma_phieu_nhap,
            $phieu->ngay_nhap,
            $phieu->sanPham->ten_sp,
            $phieu->so_luong_nhap,
            number_format($phieu->gia_nhap, 0, ',', '.'),
            number_format($phieu->so_luong_nhap * $phieu->gia_nhap, 0, ',', '.'),
        ];
    }
}