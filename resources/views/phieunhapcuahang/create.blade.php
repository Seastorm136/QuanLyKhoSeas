@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tạo phiếu nhập</h1>
        <form method="POST" action="{{ route('phieu-nhap-cua-hang.store') }}">
            @csrf
            <div class="mb-3">
                <label for="ngay_nhap" class="form-label">Ngày nhập</label>
                <input type="date" name="ngay_nhap" id="ngay_nhap" class="form-control" value="{{ now()->toDateString() }}" required>
            </div>
            <div class="mb-3">
                <label for="ma_cua_hang" class="form-label">Cửa hàng</label>
                <input type="text" class="form-control" value="{{ $cuaHang->ten_cua_hang }}" disabled>
            </div>
            <div class="mb-3">
                <label for="ma_sp" class="form-label">Sản phẩm</label>
                <select name="ma_sp" id="ma_sp" class="form-control" required>
                    @foreach($sanPhams as $sp)
                        <option value="{{ $sp->ma_sp }}">{{ $sp->ten_sp }} (Tồn: {{ $sp->so_luong_ton }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="so_luong_nhap" class="form-label">Số lượng nhập</label>
                <input type="number" name="so_luong_nhap" id="so_luong_nhap" class="form-control" min="1" required>
            </div>
            <div class="mb-3">
                <label for="ma_nv" class="form-label">Nhân viên</label>
                <input type="hidden" name="ma_nv" value="{{ auth('staff')->user()->nhanVien->ma_nv }}">
                <input type="text" class="form-control" value="{{ auth('staff')->user()->nhanVien->ten_nv }}" disabled>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{ route('tao-phieu.store_index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
@endsection