@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-4">Tạo phiếu chuyển kho</h1>
                <p class="lead">Lựa chọn loại phiếu</p>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-down-circle display-4 text-success"></i>
                        <h5 class="card-title mt-3">Tạo phiếu chuyển đến</h5>
                        <p class="card-text">Nhập hàng vào kho</p>
                        <a href="{{ route('phieu-chuyen-kho.create_den') }}" class="btn btn-success">Tạo phiếu chuyển đến</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-up-circle display-4 text-danger"></i>
                        <h5 class="card-title mt-3">Tạo phiếu chuyển đi</h5>
                        <p class="card-text">Xuất hàng từ kho</p>
                        <a href="{{ route('phieu-chuyen-kho.create_di') }}" class="btn btn-danger">Tạo phiếu chuyển đi</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center text-muted">
                <a href="{{ route('tao-phieu.warehouse_index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
            </div>
        </div>
    </div>
@endsection