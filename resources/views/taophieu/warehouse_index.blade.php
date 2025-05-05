@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-4">Tạo phiếu kho</h1>
                <p class="lead">Lựa chọn loại phiếu</p>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-down-circle display-4 text-success"></i>
                        <h5 class="card-title mt-3">Tạo phiếu nhập</h5>
                        <p class="card-text">Nhập hàng vào kho</p>
                        <a href="{{ route('phieu-nhap.create') }}" class="btn btn-success">Tạo phiếu nhập</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-up-circle display-4 text-danger"></i>
                        <h5 class="card-title mt-3">Tạo phiếu xuất</h5>
                        <p class="card-text">Xuất hàng từ kho</p>
                        <a href="{{ route('phieu-xuat.create') }}" class="btn btn-danger">Tạo phiếu xuất</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-left-right display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Tạo phiếu chuyển kho</h5>
                        <p class="card-text">Chuyển hàng giữa các kho</p>
                        <a href="{{ route('phieu-chuyen-kho.create_index') }}" class="btn btn-primary">Tạo phiếu chuyển</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center text-muted">
                <a href="{{ route('home_warehouse') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
            </div>
        </div>
    </div>
@endsection