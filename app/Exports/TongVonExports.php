<?php

namespace App\Exports;

use App\Models\Von;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class AdminTongVonExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tongVonKho;
    protected $doanhThuBanHang;
    protected $tongVonLuuDong;

    public function __construct()
    {
        $this->tongVonKho = Von::sum('tong_von');
        $this->tongVonLuuDong = \App\Models\VonLuuDong::first()->tong_von_luu_dong ?? 0;
        $thangTruoc = now()->subMonth()->startOfMonth();
        $cuoiThangTruoc = now()->subMonth()->endOfMonth();
        $this->doanhThuBanHang = DB::table('hoa_don')
            ->whereBetween('ngay_lap', [$thangTruoc, $cuoiThangTruoc])
            ->sum('tong_tien');
    }

    public function collection()
    {
        return Von::with('kho')->get();
    }

    public function headings(): array
    {
        return [
            'Mã kho',
            'Tên kho',
            'Vốn sẵn có (VND)',
            'Ngày cập nhật',
            'Tổng vốn các kho (VND)',
            'Vốn lưu động (VND)',
            'Doanh thu tháng trước (VND)',
            'Tổng vốn (VND)',
        ];
    }

    public function map($von): array
    {
        return [
            $von->ma_kho,
            $von->kho->ten_kho ?? 'N/A',
            $von->tong_von,
            $von->ngay_cap_nhat ?? 'Chưa cập nhật',
            $this->tongVonKho,
            $this->tongVonLuuDong,
            $this->doanhThuBanHang,
            $this->tongVonKho + $this->tongVonLuuDong,
        ];
    }
}