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
            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-plus display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Nhập cửa hàng</h5>
                        <p class="card-text">Báo cáo nhập cửa hàng</p>
                        <a href="{{ route('bao-cao-cua-hang.nhap_cua_hang') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-check display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Bán hàng</h5>
                        <p class="card-text">Báo cáo bán hàng</p>
                        <a href="{{ route('bao-cao-cua-hang.ban_hang') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-wallet2 display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Thu cửa hàng</h5>
                        <p class="card-text">Báo cáo thu cửa hàng</p>
                        <a href="{{ route('bao-cao-cua-hang.thu_cua_hang') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                <a href="{{ route('home_store') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
            </div>
        </div>
    </div>
@endsection