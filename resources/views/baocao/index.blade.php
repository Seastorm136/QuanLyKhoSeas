@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-4">Quản lý báo cáo</h1>
                <p class="lead">Chọn loại báo cáo để xem chi tiết hoặc xuất dữ liệu</p>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Báo cáo kho hàng -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-down-square display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Nhập kho</h5>
                        <p class="card-text">Báo cáo nhập kho</p>
                        <a href="{{ route('bao-cao.nhap_kho') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-up-square display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Xuất kho</h5>
                        <p class="card-text">Báo cáo xuất kho</p>
                        <a href="{{ route('bao-cao.xuat_kho') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-boxes display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Tồn kho</h5>
                        <p class="card-text">Báo cáo tồn kho</p>
                        <a href="{{ route('bao-cao.ton_kho') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Hàng tồn đọng</h5>
                        <p class="card-text">Báo cáo hàng tồn đọng</p>
                        <a href="{{ route('bao-cao.hang_ton_dong') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-left-right display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Chuyển kho</h5>
                        <p class="card-text">Báo cáo chuyển kho</p>
                        <a href="{{ route('bao-cao.chuyen_kho') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-stack display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Chi kho</h5>
                        <p class="card-text">Báo cáo chi kho</p>
                        <a href="{{ route('bao-cao.chi_kho') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <!-- Báo cáo cửa hàng -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-plus display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Nhập cửa hàng</h5>
                        <p class="card-text">Báo cáo nhập cửa hàng</p>
                        <a href="{{ route('bao-cao.nhap_cua_hang') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-check display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Bán hàng</h5>
                        <p class="card-text">Báo cáo bán hàng</p>
                        <a href="{{ route('bao-cao.ban_hang') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-wallet2 display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Thu cửa hàng</h5>
                        <p class="card-text">Báo cáo thu cửa hàng</p>
                        <a href="{{ route('bao-cao.thu_cua_hang') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <!-- Vốn -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-bank display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Tổng vốn</h5>
                        <p class="card-text">Tổng vốn</p>
                        <a href="{{ route('bao-cao.tong_von') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại Dashboard</a>
            </div>
        </div>
    </div>
@endsection