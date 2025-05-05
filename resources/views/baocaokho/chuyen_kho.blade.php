@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-4">Báo cáo chuyển kho</h1>
                <p class="lead">Kho: {{ $khoHang->ten_kho }}</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="GET" action="{{ route('bao-cao-kho.chuyen_kho') }}" class="mb-4">
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

                <h4 class="mb-3">Phiếu chuyển đi</h4>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Mã phiếu chuyển</th>
                                <th>Ngày chuyển</th>
                                <th>Kho nguồn</th>
                                <th>Kho đích</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng chuyển đi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($chuyenDi as $phieu)
                                <tr>
                                    <td>{{ $phieu->ma_phieu_chuyen }}</td>
                                    <td>{{ $phieu->ngay_chuyen }}</td>
                                    <td>{{ $phieu->khoNguon->ten_kho }}</td>
                                    <td>{{ $phieu->khoDich->ten_kho }}</td>
                                    <td>{{ $phieu->sanPham->ten_sp }}</td>
                                    <td>{{ $phieu->so_luong_chuyen_di }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Không có phiếu chuyển đi</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Tổng cộng:</td>
                                <td>{{ $chuyenDi->sum('so_luong_chuyen_di') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <h4 class="mb-3">Phiếu chuyển đến</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Mã phiếu chuyển</th>
                                <th>Ngày chuyển</th>
                                <th>Kho nguồn</th>
                                <th>Kho đích</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng chuyển đến</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($chuyenDen as $phieu)
                                <tr>
                                    <td>{{ $phieu->ma_phieu_chuyen }}</td>
                                    <td>{{ $phieu->ngay_chuyen }}</td>
                                    <td>{{ $phieu->khoNguon->ten_kho }}</td>
                                    <td>{{ $phieu->khoDich->ten_kho }}</td>
                                    <td>{{ $phieu->sanPham->ten_sp }}</td>
                                    <td>{{ $phieu->so_luong_chuyen_den }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Không có phiếu chuyển đến</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Tổng cộng:</td>
                                <td>{{ $chuyenDen->sum('so_luong_chuyen_den') }}</td>
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