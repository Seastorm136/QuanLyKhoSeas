@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">Trang chủ nhân viên kho</h1>
            <p class="lead">Chào mừng {{ auth('staff')->user()->nhanVien?->ten_nv ?? 'Nhân viên' }} đến với SEAS</p>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse(auth('staff')->user()->nhanVien->khoHangs as $khoHang)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Sản phẩm</h5>
                        <p class="card-text">Quản lý danh sách sản phẩm</p>
                        <a href="{{ route('chi-tiet-kho-hang.index') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Báo cáo</h5>
                        <p class="card-text">Quản lý báo cáo</p>
                        <a href="{{ route('bao-cao-kho.index') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-plus-circle display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Tạo phiếu</h5>
                        <p class="card-text">Tạo phiếu nhập, xuất, chuyển kho</p>
                        <a href="{{ route('tao-phieu.warehouse_index') }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                <p>Bạn chưa được phân công quản lý kho hàng nào.</p>
            </div>
        @endforelse
    </div>
@endsection