@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white text-center">
                        <h2 class="mb-0 fs-4"><i class="bi bi-plus-circle me-2"></i>Thêm nhân viên mới</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('nhan-vien.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="ma_nv" class="form-label fw-bold">Mã nhân viên</label>
                                <input type="text" name="ma_nv" id="ma_nv" class="form-control @error('ma_nv') is-invalid @enderror" value="{{ old('ma_nv') }}" required placeholder="VD: NV001">
                                @error('ma_nv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ten_nv" class="form-label fw-bold">Tên nhân viên</label>
                                <input type="text" name="ten_nv" id="ten_nv" class="form-control @error('ten_nv') is-invalid @enderror" value="{{ old('ten_nv') }}" required placeholder="Nhập họ tên">
                                @error('ten_nv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gioitinh" class="form-label fw-bold">Giới tính</label>
                                <select name="gioitinh" id="gioitinh" class="form-select @error('gioitinh') is-invalid @enderror" required>
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam" {{ old('gioitinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                    <option value="Nữ" {{ old('gioitinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                </select>
                                @error('gioitinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ngay_sinh" class="form-label fw-bold">Ngày sinh</label>
                                <input type="date" name="ngay_sinh" id="ngay_sinh" class="form-control @error('ngay_sinh') is-invalid @enderror" value="{{ old('ngay_sinh') }}" required>
                                @error('ngay_sinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="so_dt" class="form-label fw-bold">Số điện thoại</label>
                                <input type="text" name="so_dt" id="so_dt" class="form-control @error('so_dt') is-invalid @enderror" value="{{ old('so_dt') }}" required placeholder="VD: 0901234567">
                                @error('so_dt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dia_chi" class="form-label fw-bold">Địa chỉ</label>
                                <input type="text" name="dia_chi" id="dia_chi" class="form-control @error('dia_chi') is-invalid @enderror" value="{{ old('dia_chi') }}" required placeholder="Nhập địa chỉ">
                                @error('dia_chi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="chuc_vu" class="form-label fw-bold">Chức vụ</label>
                                <select name="chuc_vu" id="chuc_vu" class="form-select @error('chuc_vu') is-invalid @enderror" required>
                                    <option value="">Chọn chức vụ</option>
                                    <option value="Nhân viên kho" {{ old('chuc_vu') == 'Nhân viên kho' ? 'selected' : '' }}>Nhân viên kho</option>
                                    <option value="Nhân viên bán hàng" {{ old('chuc_vu') == 'Nhân viên bán hàng' ? 'selected' : '' }}>Nhân viên bán hàng</option>
                                </select>
                                @error('chuc_vu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ten_tknh" class="form-label fw-bold">Tên tài khoản ngân hàng</label>
                                <input type="text" name="ten_tknh" id="ten_tknh" class="form-control @error('ten_tknh') is-invalid @enderror" value="{{ old('ten_tknh') }}" required placeholder="VD: Vietcombank">
                                @error('ten_tknh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="so_tknh" class="form-label fw-bold">Số tài khoản ngân hàng</label>
                                <input type="text" name="so_tknh" id="so_tknh" class="form-control @error('so_tknh') is-invalid @enderror" value="{{ old('so_tknh') }}" required placeholder="VD: 1234567890">
                                @error('so_tknh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ten_dn" class="form-label fw-bold">Tên đăng nhập</label>
                                <input type="text" name="ten_dn" id="ten_dn" class="form-control @error('ten_dn') is-invalid @enderror" value="{{ old('ten_dn') }}" required placeholder="VD: nhanvien001">
                                @error('ten_dn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Mật khẩu</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Nhập mật khẩu">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Lưu
                                </button>
                                <a href="{{ route('nhan-vien.index') }}" class="btn btn-secondary">
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