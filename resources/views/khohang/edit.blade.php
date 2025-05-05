@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white text-center">
                        <h2 class="mb-0 fs-4"><i class="bi bi-pencil-square me-2"></i>Sửa kho hàng: {{ $khoHang->ten_kho }}</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('kho-hang.update', $khoHang->ma_kho) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="ma_kho" class="form-label fw-bold">Mã kho</label>
                                <input type="text" name="ma_kho" id="ma_kho" class="form-control @error('ma_kho') is-invalid @enderror" value="{{ old('ma_kho', $khoHang->ma_kho) }}" required placeholder="VD: KHO001">
                                <small class="text-muted">Mã cũ: {{ $khoHang->ma_kho }}</small>
                                @error('ma_kho')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ten_kho" class="form-label fw-bold">Tên kho</label>
                                <input type="text" name="ten_kho" id="ten_kho" class="form-control @error('ten_kho') is-invalid @enderror" value="{{ old('ten_kho', $khoHang->ten_kho) }}" required placeholder="Nhập tên kho">
                                @error('ten_kho')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ma_nv" class="form-label fw-bold">Nhân viên quản lý</label>
                                <select name="ma_nv" id="ma_nv" class="form-select @error('ma_nv') is-invalid @enderror" required>
                                    <option value="">Chọn nhân viên</option>
                                    @foreach($availableNhanVien as $nv)
                                        <option value="{{ $nv->ma_nv }}" {{ old('ma_nv', $khoHang->ma_nv) == $nv->ma_nv ? 'selected' : '' }}>{{ $nv->ten_nv }} ({{ $nv->ma_nv }})</option>
                                    @endforeach
                                </select>
                                @error('ma_nv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Cập nhật
                                </button>
                                <a href="{{ route('kho-hang.index') }}" class="btn btn-secondary">
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