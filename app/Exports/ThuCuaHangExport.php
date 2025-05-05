<?php

namespace App\Exports;

use App\Models\Von;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminThuCuaHangExport implements FromCollection, WithHeadings
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
        $query = Von::where('loai_giao_dich', 'Bán hàng');
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

class ThuCuaHangExport implements FromCollection, WithHeadings
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
        $query = Von::where('loai_giao_dich', 'Bán hàng')
            ->where('ma_cua_hang', $this->maCuaHang);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_giao_dich', [$this->startDate, $this->endDate]);
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Mã giao dịch', 
            'Ngày giao dịch', 
            'Số tiền', 
            'Mô tả',
        ];
    }

    public function map($von): array
    {
        return [
            $von->ma_giao_dich,
            $von->ngay_giao_dich,
            $von->so_tien,
            $von->mo_ta,
        ];
    }
}