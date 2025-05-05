@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header bg-danger text-white text-center">
            <h2 class="mb-0">Chi tiết sản phẩm: {{ $sanPham->ten_sp }}</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Mã SP:</strong> {{ $sanPham->ma_sp }}</p>
                <p><strong>Tên SP:</strong> {{ $sanPham->ten_sp }}</p>
                <p><strong>Đơn vị tính:</strong> {{ $sanPham->don_vi_tinh }}</p>
                <p><strong>Số lượng:</strong> {{ $sanPham->so_luong }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Giá nhập:</strong> {{ number_format($sanPham->gia_nhap, 0, ',', '.') }} VNĐ</p>
                <p><strong>Giá bán buôn:</strong> {{ number_format($sanPham->ban_buon, 0, ',', '.') }} VNĐ</p>
                <p><strong>Giá bán lẻ:</strong> {{ number_format($sanPham->ban_le, 0, ',', '.') }} VNĐ</p>
                <p><strong>Loại SP:</strong> {{ $sanPham->loai_sp }}</p>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('kho-hang.show', $ma_kho) }}" class="btn btn-primary">
                <i class="bi bi-house-fill"></i> Quay lại kho hàng
            </a>
        </div>
    </div>
@endsection