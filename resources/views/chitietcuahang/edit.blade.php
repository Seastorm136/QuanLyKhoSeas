@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white text-center">
                        <h2 class="mb-0 fs-4"><i class="bi bi-pencil-square me-2"></i>Sửa số lượng sản phẩm trong cửa hàng</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('chi-tiet-cua-hang.update', [$chiTiet->ma_cua_hang, $chiTiet->ma_sp]) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="ma_cua_hang" class="form-label fw-bold">Mã cửa hàng</label>
                                <input type="text" name="ma_cua_hang" id="ma_cua_hang" class="form-control" value="{{ $chiTiet->ma_cua_hang }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="ma_sp" class="form-label fw-bold">Mã sản phẩm</label>
                                <input type="text" name="ma_sp" id="ma_sp" class="form-control" value="{{ $chiTiet->ma_sp }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="so_luong" class="form-label fw-bold">Số lượng</label>
                                <input type="number" name="so_luong" id="so_luong" class="form-control @error('so_luong') is-invalid @enderror" value="{{ old('so_luong', $chiTiet->so_luong) }}" min="0" required>
                                @error('so_luong')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Cập nhật
                                </button>
                                <a href="{{ route('cua-hang.show', $chiTiet->ma_cua_hang) }}" class="btn btn-secondary">
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