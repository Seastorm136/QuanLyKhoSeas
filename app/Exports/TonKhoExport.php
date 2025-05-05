<?php

namespace App\Exports;

use App\Models\ChiTietKhoHang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminTonKhoExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ChiTietKhoHang::with('sanPham', 'khoHang')->get()->map(function ($item) {
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

class TonKhoExport implements FromCollection, WithHeadings, WithMapping
{
    protected $maKho;

    public function __construct($maKho)
    {
        $this->maKho = $maKho;
    }

    public function collection()
    {
        return ChiTietKhoHang::with('sanPham', 'khoHang')
            ->where('ma_kho', $this->maKho)
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