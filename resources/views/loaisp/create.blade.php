@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white text-center">
                        <h2 class="mb-0 fs-4"><i class="bi bi-plus-circle me-2"></i>Thêm loại sản phẩm mới</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loai-sp.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="loai_sp" class="form-label fw-bold">Loại sản phẩm</label>
                                <input type="text" name="loai_sp" id="loai_sp" class="form-control @error('loai_sp') is-invalid @enderror" value="{{ old('loai_sp') }}" required placeholder="Nhập loại sản phẩm">
                                @error('loai_sp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Lưu
                                </button>
                                <a href="{{ route('loai-sp.index') }}" class="btn btn-secondary">
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