@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-4">Báo cáo xuất kho</h1>
                <p class="lead">{{ $khoHang->ten_kho }}</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="GET" action="{{ route('bao-cao-kho.xuat_kho') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Từ ngày</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Đến ngày</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary w-50"><i class="bi bi-search me-2"></i>Lọc</button>
                            <button type="submit" name="export" value="1" class="btn btn-success w-50"><i class="bi bi-file-earmark-excel me-2"></i>Xuất Excel</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Mã phiếu xuất</th>
                                <th>Ngày xuất</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng xuất</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($xuatKho as $phieu)
                                <tr>
                                    <td>{{ $phieu->ma_phieu_xuat }}</td>
                                    <td>{{ $phieu->ngay_xuat }}</td>
                                    <td>{{ $phieu->sanPham->ten_sp }}</td>
                                    <td>{{ $phieu->so_luong_xuat }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Không có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                <td>{{ $xuatKho->sum('so_luong_xuat') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('bao-cao-kho.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
                </div>
            </div>
        </div>
    </div>
@endsection