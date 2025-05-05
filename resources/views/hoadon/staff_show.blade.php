@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-6 fw-bold text-danger">Chi tiết hóa đơn: {{ $hoaDon->ma_hoa_don }}</h1>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-danger text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fs-4">Thông tin hóa đơn: {{ $hoaDon->ma_hoa_don }}</h2>
                    <div>
                        <a href="{{ route('hoa-don.edit', $hoaDon->ma_hoa_don) }}" class="btn btn-light btn-sm me-2">
                            <i class="bi bi-pencil"></i> Sửa
                        </a>
                        <a href="{{ route('hoa-don.staff_index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label fw-bold">Mã hóa đơn:</label>
                    <p>{{ $hoaDon->ma_hoa_don }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Ngày lập:</label>
                    <p>{{ \Carbon\Carbon::parse($hoaDon->ngay_lap)->format('d/m/Y') }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nhân viên lập:</label>
                    <p>{{ $hoaDon->nhanVien->ten_nv }} ({{ $hoaDon->ma_nv }})</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Mã SP</th>
                                <th scope="col">Tên SP</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Đơn giá</th>
                                <th scope="col">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hoaDon->chiTietHoaDons as $chiTiet)
                                <tr>
                                    <td>{{ $chiTiet->ma_sp }}</td>
                                    <td>{{ $chiTiet->sanPham->ten_sp }}</td>
                                    <td>
                                        <span class="badge {{ $chiTiet->so_luong > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $chiTiet->so_luong }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ number_format($chiTiet->don_gia, 0, ',', '.') }} VNĐ
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ number_format($chiTiet->thanh_tien, 0, ',', '.') }} VNĐ
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-receipt-cutoff me-2"></i> Chưa có sản phẩm nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Tổng tiền:</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ number_format($hoaDon->tong_tien, 0, ',', '.') }} VNĐ
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection