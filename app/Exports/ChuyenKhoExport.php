<?php

namespace App\Exports;

use App\Models\PhieuChuyenKho;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AdminChuyenKhoExport implements WithMultipleSheets
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function sheets(): array
    {
        return [
            'ChuyenDi' => new AdminChuyenDiSheet($this->startDate, $this->endDate),
            'ChuyenDen' => new AdminChuyenDenSheet($this->startDate, $this->endDate),
        ];
    }
}

class AdminChuyenDiSheet implements FromCollection, WithHeadings, WithMapping
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
        $query = PhieuChuyenKho::with(['sanPham', 'khoNguon', 'khoDich']);
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_chuyen', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Mã phiếu chuyển',
            'Ngày chuyển',
            'Kho nguồn',
            'Kho đích',
            'Sản phẩm',
            'Số lượng chuyển đi',
        ];
    }

    public function map($phieu): array
    {
        return [
            $phieu->ma_phieu_chuyen,
            $phieu->ngay_chuyen,
            $phieu->khoNguon->ten_kho,
            $phieu->khoDich->ten_kho,
            $phieu->sanPham->ten_sp,
            $phieu->so_luong_chuyen_di,
        ];
    }
}

class AdminChuyenDenSheet implements FromCollection, WithHeadings, WithMapping
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
        $query = PhieuChuyenKho::with(['sanPham', 'khoNguon', 'khoDich']);
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_chuyen', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Mã phiếu chuyển',
            'Ngày chuyển',
            'Kho nguồn',
            'Kho đích',
            'Sản phẩm',
            'Số lượng chuyển đến',
        ];
    }

    public function map($phieu): array
    {
        return [
            $phieu->ma_phieu_chuyen,
            $phieu->ngay_chuyen,
            $phieu->khoNguon->ten_kho,
            $phieu->khoDich->ten_kho,
            $phieu->sanPham->ten_sp,
            $phieu->so_luong_chuyen_den,
        ];
    }
}

class ChuyenKhoExport implements WithMultipleSheets
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

    public function sheets(): array
    {
        return [
            'ChuyenDi' => new ChuyenDiSheet($this->startDate, $this->endDate, $this->maKho),
            'ChuyenDen' => new ChuyenDenSheet($this->startDate, $this->endDate, $this->maKho),
        ];
    }
}

class ChuyenDiSheet implements FromCollection, WithHeadings, WithMapping
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
        $query = PhieuChuyenKho::with(['sanPham', 'khoNguon', 'khoDich'])
            ->where('ma_kho_nguon', $this->maKho);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_chuyen', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Mã phiếu chuyển',
            'Ngày chuyển',
            'Kho nguồn',
            'Kho đích',
            'Sản phẩm',
            'Số lượng chuyển đi',
        ];
    }

    public function map($phieu): array
    {
        return [
            $phieu->ma_phieu_chuyen,
            $phieu->ngay_chuyen,
            $phieu->khoNguon->ten_kho,
            $phieu->khoDich->ten_kho,
            $phieu->sanPham->ten_sp,
            $phieu->so_luong_chuyen_di,
        ];
    }
}

class ChuyenDenSheet implements FromCollection, WithHeadings, WithMapping
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
        $query = PhieuChuyenKho::with(['sanPham', 'khoNguon', 'khoDich'])
            ->where('ma_kho_dich', $this->maKho);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('ngay_chuyen', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Mã phiếu chuyển',
            'Ngày chuyển',
            'Kho nguồn',
            'Kho đích',
            'Sản phẩm',
            'Số lượng chuyển đến',
        ];
    }

    public function map($phieu): array
    {
        return [
            $phieu->ma_phieu_chuyen,
            $phieu->ngay_chuyen,
            $phieu->khoNguon->ten_kho,
            $phieu->khoDich->ten_kho,
            $phieu->sanPham->ten_sp,
            $phieu->so_luong_chuyen_den,
        ];
    }
}