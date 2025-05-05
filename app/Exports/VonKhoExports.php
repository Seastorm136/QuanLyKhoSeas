<?php

namespace App\Exports;

use App\Models\Von;
use App\Models\KhoHang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class VonKhoExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        $nhanVien = Auth::guard('staff')->user()->nhanVien;
        $ma_nv = $nhanVien->ma_nv;
        $khoHang = KhoHang::where('ma_nv', $ma_nv)->firstOrFail();
        $ma_kho = $khoHang->ma_kho;

        return Von::where('ma_kho', $ma_kho)->get();
    }

    public function headings(): array
    {
        return [
            'Mã kho',
            'Tên kho',
            'Tổng vốn (VNĐ)',
            'Ngày cập nhật',
        ];
    }

    public function map($von): array
    {
        $khoHang = KhoHang::where('ma_kho', $von->ma_kho)->first();
        return [
            $von->ma_kho,
            $khoHang->ten_kho,
            $von->tong_von,
            $von->ngay_cap_nhat->format('d/m/Y H:i:s'),
        ];
    }
}