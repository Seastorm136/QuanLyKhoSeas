@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tạo phiếu xuất</h1>
        <form method="POST" action="{{ route('phieu-xuat.store') }}">
            @csrf
            <div class="mb-3">
                <label for="ngay_xuat" class="form-label">Ngày xuất</label>
                <input type="date" name="ngay_xuat" id="ngay_xuat" class="form-control" value="{{ now()->toDateString() }}" required>
            </div>
            <div class="mb-3">
                <label for="ma_kho" class="form-label">Kho</label>
                <input type="text" class="form-control" value="{{ $khoHang->ten_kho }}" disabled>
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
                <label for="so_luong_xuat" class="form-label">Số lượng xuất</label>
                <input type="number" name="so_luong_xuat" id="so_luong_xuat" class="form-control" min="1" required>
            </div>
            <div class="mb-3">
                <label for="ma_nv" class="form-label">Nhân viên</label>
                <input type="hidden" name="ma_nv" value="{{ auth('staff')->user()->nhanVien->ma_nv }}">
                <input type="text" class="form-control" value="{{ auth('staff')->user()->nhanVien->ten_nv }}" disabled>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{ route('tao-phieu.warehouse_index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
@endsection