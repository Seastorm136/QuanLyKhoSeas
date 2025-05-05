<?php

namespace App\Exports;

use App\Models\ChiTietKhoHang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminHangTonDongExport implements FromCollection, WithHeadings
{
    protected $days;

    public function __construct($days)
    {
        $this->days = $days;
    }

    public function collection()
    {
        return ChiTietKhoHang::with('sanPham', 'khoHang')
            ->whereDoesntHave('phieuNhap', function ($q) {
                $q->where('ngay_nhap', '>=', now()->subDays($this->days));
            })
            ->whereDoesntHave('phieuXuat', function ($q) {
                $q->where('ngay_xuat', '>=', now()->subDays($this->days));
            })
            ->whereDoesntHave('phieuChuyenKhoNguon', function ($q) {
                $q->where('ngay_chuyen', '>=', now()->subDays($this->days));
            })
            ->whereDoesntHave('phieuChuyenKhoDich', function ($q) {
                $q->where('ngay_chuyen', '>=', now()->subDays($this->days));
            })
            ->get()->map(function ($item) {
                return [
                    'ten_kho' => $item->khoHang->ten_kho,
                    'ten_sp' => $item->sanPham->ten_sp,
                    'so_luong_ton' => $item->so_luong,
                ];
            });
    }

    public function headings(): array
    {
        return ['Kho', 'Sản phẩm', 'Số lượng tồn'];
    }
}

class HangTonDongExport implements FromCollection, WithHeadings, WithMapping
{
    protected $days;
    protected $maKho;

    public function __construct($days, $maKho)
    {
        $this->days = $days;
        $this->maKho = $maKho;
    }

    public function collection()
    {
        return ChiTietKhoHang::with('sanPham', 'khoHang')
            ->where('ma_kho', $this->maKho)
            ->whereDoesntHave('phieuNhap', function ($q) {
                $q->where('ngay_nhap', '>=', now()->subDays($this->days));
            })
            ->whereDoesntHave('phieuXuat', function ($q) {
                $q->where('ngay_xuat', '>=', now()->subDays($this->days));
            })
            ->whereDoesntHave('phieuChuyenKhoNguon', function ($q) {
                $q->where('ngay_chuyen', '>=', now()->subDays($this->days));
            })
            ->whereDoesntHave('phieuChuyenKhoDich', function ($q) {
                $q->where('ngay_chuyen', '>=', now()->subDays($this->days));
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            'Sản phẩm',
            'Số lượng tồn',
        ];
    }

    public function map($item): array
    {
        return [
            $item->sanPham->ten_sp,
            $item->so_luong,
        ];
    }
}