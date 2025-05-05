@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-primary">Báo cáo vốn kho</h1>
            <a href="{{ route('bao-cao-kho.von_kho', ['export' => 'excel']) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Xuất Excel
            </a>
        </div>

        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-primary text-white rounded-top">
                <h5 class="card-title mb-0">Thông tin vốn kho</h5>
            </div>
            <div class="card-body p-4">
                <table class="table table-borderless table-hover">
                    <tbody>
                        <tr>
                            <th scope="row" class="fw-bold text-muted" style="width: 30%;">Mã kho</th>
                            <td>{{ $khoHang->ma_kho }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold text-muted">Tên kho</th>
                            <td>{{ $khoHang->ten_kho }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold text-muted">Tổng vốn kho</th>
                            <td class="fs-4 fw-bold text-success">{{ number_format($vonKho, 2, ',', '.') }} VNĐ</td>
                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold text-muted">Ngày cập nhật</th>
                            <td>{{ $ngayCapNhat->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light text-end rounded-bottom">
                <a href="{{ route('home_warehouse') }}" class="btn btn-outline-secondary">Quay lại</a>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('styles')
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }
        .table th, .table td {
            padding: 1rem;
            vertical-align: middle;
        }
        .text-primary {
            color: #007bff !important;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
@endsection