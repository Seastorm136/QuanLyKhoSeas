@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white text-center">
                        <h2 class="mb-0 fs-4"><i class="bi bi-plus-circle me-2"></i>Thêm sản phẩm mới</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('san-pham.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="ma_sp" class="form-label fw-bold">Mã sản phẩm</label>
                                <input type="text" name="ma_sp" id="ma_sp" class="form-control @error('ma_sp') is-invalid @enderror" value="{{ old('ma_sp') }}" required>
                                @error('ma_sp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ten_sp" class="form-label fw-bold">Tên sản phẩm</label>
                                <input type="text" name="ten_sp" id="ten_sp" class="form-control @error('ten_sp') is-invalid @enderror" value="{{ old('ten_sp') }}" required>
                                @error('ten_sp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="don_vi_tinh" class="form-label fw-bold">Đơn vị tính</label>
                                <input type="text" name="don_vi_tinh" id="don_vi_tinh" class="form-control @error('don_vi_tinh') is-invalid @enderror" value="{{ old('don_vi_tinh') }}" required>
                                @error('don_vi_tinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gia_nhap" class="form-label fw-bold">Giá nhập</label>
                                <input type="number" name="gia_nhap" id="gia_nhap" class="form-control @error('gia_nhap') is-invalid @enderror" value="{{ old('gia_nhap', 0) }}" min="0" step="1000" required>
                                @error('gia_nhap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ban_buon" class="form-label fw-bold">Giá bán buôn</label>
                                <input type="number" name="ban_buon" id="ban_buon" class="form-control @error('ban_buon') is-invalid @enderror" value="{{ old('ban_buon', 0) }}" min="0" step="1000" required>
                                @error('ban_buon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ban_le" class="form-label fw-bold">Giá bán lẻ</label>
                                <input type="number" name="ban_le" id="ban_le" class="form-control @error('ban_le') is-invalid @enderror" value="{{ old('ban_le', 0) }}" min="0" step="1000" required>
                                @error('ban_le')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="loai_sp" class="form-label fw-bold">Loại sản phẩm</label>
                                <select name="loai_sp" id="loai_sp" class="form-select @error('loai_sp') is-invalid @enderror" required>
                                    <option value="">Chọn loại sản phẩm</option>
                                    @foreach($loaiSPs as $loai)
                                        <option value="{{ $loai->loai_sp }}" {{ old('loai_sp') == $loai->loai_sp ? 'selected' : '' }}>{{ $loai->loai_sp }}</option>
                                    @endforeach
                                </select>
                                @error('loai_sp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Lưu
                                </button>
                                <a href="{{ route('san-pham.index') }}" class="btn btn-secondary">
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