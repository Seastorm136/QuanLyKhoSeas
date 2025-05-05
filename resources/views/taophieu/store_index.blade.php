@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-4">Tạo phiếu kho</h1>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-1 g-4">
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-down-circle display-4 text-success"></i>
                        <h5 class="card-title mt-3">Tạo phiếu nhập</h5>
                        <p class="card-text">Nhập hàng vào cửa hàng</p>
                        <a href="{{ route('phieu-nhap-cua-hang.create') }}" class="btn btn-success">Tạo phiếu nhập</a>
                    </div>
                </div>
            </div>

        <div class="row mt-5">
            <div class="col-12 text-center text-muted">
                <a href="{{ route('home_store') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
            </div>
        </div>
    </div>
@endsection