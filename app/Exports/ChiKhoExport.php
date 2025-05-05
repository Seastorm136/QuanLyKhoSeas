<?php

namespace App\Exports;

use App\Models\Von;
use App\Models\PhieuNhap;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminChiKhoExport implements FromCollection, WithHeadings
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
        $query = Von::where('loai_giao_dich', 'Nhập kho');
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_giao_dich', [$this->startDate, $this->endDate]);
        }
        return $query->get()->map(function ($von) {
            return [
                'ma_giao_dich' => $von->ma_giao_dich,
                'ngay_giao_dich' => $von->ngay_giao_dich,
                'so_tien' => $von->so_tien,
                'mo_ta' => $von->mo_ta,
            ];
        });
    }

    public function headings(): array
    {
        return ['Mã giao dịch', 'Ngày giao dịch', 'Số tiền', 'Mô tả'];
    }
}

class ChiKhoExport implements FromCollection, WithHeadings, WithMapping
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
        $query = PhieuNhap::with('sanPham', 'khoHang')
            ->where('ma_kho', $this->maKho)
            ->whereNotNull('gia_nhap');

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
            'Chi phí',
        ];
    }

    public function map($phieu): array
    {
        return [
            $phieu->ma_phieu_nhap,
            $phieu->ngay_nhap,
            $phieu->sanPham->ten_sp,
            $phieu->so_luong_nhap,
            number_format($phieu->so_luong_nhap * $phieu->gia_nhap, 0, ',', '.'),
        ];
    }
}