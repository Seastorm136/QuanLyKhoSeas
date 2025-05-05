@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-primary">Thông tin nhân viên: {{ $nhanVien->ten_nv }}</h1>
            <a href="{{ route('nhan-vien.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>

        <div class="card shadow-lg border-0 rounded-3 mb-4">
            <div class="card-header bg-gradient-primary text-white rounded-top">
                <h5 class="card-title mb-0">Chi tiết nhân viên</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Mã NV:</strong> {{ $nhanVien->ma_nv }}</p>
                        <p><strong>Tên NV:</strong> {{ $nhanVien->ten_nv }}</p>
                        <p><strong>Giới tính:</strong> {{ $nhanVien->gioitinh }}</p>
                        <p><strong>Ngày sinh:</strong> {{ \Carbon\Carbon::parse($nhanVien->ngay_sinh)->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>SĐT:</strong> {{ $nhanVien->so_dt }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $nhanVien->dia_chi ?? 'Chưa cập nhật' }}</p>
                        <p><strong>Chức vụ:</strong> {{ $nhanVien->chuc_vu }}</p>
                        <p><strong>Tên đăng nhập:</strong> {{ $nhanVien->ten_dn }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-lg border-0 rounded-3 mb-4">
            <div class="card-header bg-gradient-info text-white rounded-top">
                <h5 class="card-title mb-0">Thông tin tài khoản ngân hàng</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Tên tài khoản:</strong> {{ $nhanVien->ten_tknh ?? 'Chưa cập nhật' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Số tài khoản:</strong> {{ $nhanVien->so_tknh ?? 'Chưa cập nhật' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-gradient-success text-white rounded-top">
                <h5 class="card-title mb-0">Thông tin liên quan</h5>
            </div>
            <div class="card-body p-4">
                @if($nhanVien->chuc_vu === 'Nhân viên kho')
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Kho quản lý:</strong> {{ $nhanVien->khoHangs->count() }}</p>
                            @if($nhanVien->khoHangs->isNotEmpty())
                                <ul class="list-unstyled">
                                    @foreach($nhanVien->khoHangs as $kho)
                                        <li>{{ $kho->ten_kho }} ({{ $kho->ma_kho }})</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Chưa quản lý kho nào.</p>
                            @endif
                        </div>
                    </div>
                @elseif($nhanVien->chuc_vu === 'Nhân viên bán hàng')
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Cửa hàng quản lý:</strong> {{ $nhanVien->cuaHangs->count() }}</p>
                            @if($nhanVien->cuaHangs->isNotEmpty())
                                <ul class="list-unstyled">
                                    @foreach($nhanVien->cuaHangs as $cuaHang)
                                        <li>{{ $cuaHang->ten_cua_hang }} ({{ $cuaHang->ma_cua_hang }})</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Chưa quản lý cửa hàng nào.</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p><strong>Số hóa đơn:</strong> {{ $nhanVien->hoaDons->count() }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-muted">Không có thông tin liên quan cho chức vụ này.</p>
                @endif
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
        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #00b4ff);
        }
        .bg-gradient-info {
            background: linear-gradient(45deg, #17a2b8, #3ec8d9);
        }
        .bg-gradient-success {
            background: linear-gradient(45deg, #28a745, #48c768);
        }
        .card-body p {
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        .card-body strong {
            color: #333;
            min-width: 120px;
            display: inline-block;
        }
        .text-primary {
            color: #007bff !important;
        }
    </style>
@endsection