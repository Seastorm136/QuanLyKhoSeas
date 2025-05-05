@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">Bảng điều khiển</h1>
            <p class="lead">Chào mừng đến với SEAS</p>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Sản phẩm</h5>
                    <p class="card-text">Quản lý danh sách sản phẩm</p>
                    <a href="{{ route('san-pham.index') }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Nhân viên</h5>
                    <p class="card-text">Quản lý thông tin nhân viên</p>
                    <a href="{{ route('nhan-vien.index') }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-house-fill display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Kho hàng</h5>
                    <p class="card-text">Quản lý thông tin kho</p>
                    <a href="{{ route('kho-hang.index') }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-shop display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Cửa hàng</h5>
                    <p class="card-text">Quản lý thông tin cửa hàng</p>
                    <a href="{{ route('cua-hang.index') }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-receipt display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Hóa đơn</h5>
                    <p class="card-text">Quản lý hóa đơn</p>
                    <a href="{{ route('hoa-don.index') }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-tag-fill display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Loại sản phẩm</h5>
                    <p class="card-text">Quản lý loại sản phẩm</p>
                    <a href="{{ route('loai-sp.index') }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-bar-graph display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Quản lý báo cáo</h5>
                    <p class="card-text">Xem và xuất các loại báo cáo</p>
                    <a href="{{ route('bao-cao.index') }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>
@endsection