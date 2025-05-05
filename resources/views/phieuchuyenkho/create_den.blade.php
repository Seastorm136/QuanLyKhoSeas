@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tạo phiếu chuyển đến</h1>
        <form method="POST" action="{{ route('phieu-chuyen-kho.store_den') }}">
            @csrf
            <div class="mb-3">
                <label for="ngay_chuyen" class="form-label">Ngày chuyển</label>
                <input type="date" name="ngay_chuyen" id="ngay_chuyen" class="form-control" value="{{ now()->toDateString() }}" required>
            </div>
            <div class="mb-3">
                <label for="ma_kho_nguon" class="form-label">Kho nguồn</label>
                <select name="ma_kho_nguon" id="ma_kho_nguon" class="form-control" required>
                    @foreach($khoHangs as $kho)
                        <option value="{{ $kho->ma_kho }}">{{ $kho->ten_kho }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="ma_kho_dich" class="form-label">Kho đích</label>
                <input type="text" class="form-control" value="{{ $khoHangDich->ten_kho }}" disabled>
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
                <label for="so_luong_chuyen_den" class="form-label">Số lượng chuyển</label>
                <input type="number" name="so_luong_chuyen_den" id="so_luong_chuyen_den_den" class="form-control" min="1" required>
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