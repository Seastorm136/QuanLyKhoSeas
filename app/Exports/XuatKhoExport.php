<?php

namespace App\Exports;

use App\Models\PhieuXuat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminXuatKhoExport implements FromCollection, WithHeadings
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
        $query = PhieuXuat::with('sanPham', 'khoHang');
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_xuat', [$this->startDate, $this->endDate]);
        }
        return $query->get()->map(function ($phieu) {
            return [
                'ma_phieu_xuat' => $phieu->ma_phieu_xuat,
                'ngay_xuat' => $phieu->ngay_xuat,
                'ten_kho' => $phieu->khoHang->ten_kho,
                'ten_sp' => $phieu->sanPham->ten_sp,
                'so_luong_xuat' => $phieu->so_luong_xuat,
            ];
        });
    }

    public function headings(): array
    {
        return ['Mã phiếu xuất', 'Ngày xuất', 'Kho', 'Sản phẩm', 'Số lượng xuất'];
    }
}

class XuatKhoExport implements FromCollection, WithHeadings, WithMapping
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
        $query = PhieuXuat::with('sanPham', 'khoHang')
            ->where('ma_kho', $this->maKho);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_xuat', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Mã phiếu xuất',
            'Ngày xuất',
            'Sản phẩm',
            'Số lượng xuất',
        ];
    }

    public function map($phieu): array
    {
        return [
            $phieu->ma_phieu_xuat,
            $phieu->ngay_xuat,
            $phieu->sanPham->ten_sp,
            $phieu->so_luong_xuat,
        ];
    }
}