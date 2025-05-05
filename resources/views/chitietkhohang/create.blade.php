@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white text-center">
                        <h2 class="mb-0 fs-4"><i class="bi bi-plus-circle me-2"></i>Thêm chi tiết kho: {{ $khoHang->ten_kho }}</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('chi-tiet-kho-hang.store') }}">
                            @csrf
                            <input type="hidden" name="ma_kho" value="{{ $khoHang->ma_kho }}">
                            <div class="mb-3">
                                <label for="ma_sp" class="form-label fw-bold">Mã sản phẩm</label>
                                <select name="ma_sp" id="ma_sp" class="form-select @error('ma_sp') is-invalid @enderror" required>
                                    <option value="">Chọn sản phẩm</option>
                                    @foreach($sanPhams as $sp)
                                        <option value="{{ $sp->ma_sp }}" {{ old('ma_sp') == $sp->ma_sp ? 'selected' : '' }}>{{ $sp->ten_sp }} ({{ $sp->ma_sp }})</option>
                                    @endforeach
                                </select>
                                @error('ma_sp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="so_luong" class="form-label fw-bold">Số lượng</label>
                                <input type="number" name="so_luong" id="so_luong" class="form-control @error('so_luong') is-invalid @enderror" value="{{ old('so_luong', 0) }}" min="0" required>
                                @error('so_luong')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Lưu
                                </button>
                                <a href="{{ route('kho-hang.show', $khoHang->ma_kho) }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection