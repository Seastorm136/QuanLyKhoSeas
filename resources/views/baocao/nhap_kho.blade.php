@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white text-center">
                        <h2 class="mb-0 fs-4"><i class="bi bi-file-earmark-text me-2"></i>Báo cáo nhập kho</h2>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('bao-cao.nhap_kho') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="start_date" class="form-label">Từ ngày</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="end_date" class="form-label">Đến ngày</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-50"><i class="bi bi-search me-2"></i>Lọc</button>
                                    <button type="submit" name="export" value="excel" class="btn btn-success w-50"><i class="bi bi-file-earmark-excel me-2"></i>Xuất Excel</button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Mã phiếu nhập</th>
                                    <th>Ngày nhập</th>
                                    <th>Kho</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá nhập</th>
                                    <th>Tổng chi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nhapKho as $phieu)
                                    <tr>
                                        <td>{{ $phieu->ma_phieu_nhap }}</td>
                                        <td>{{ $phieu->ngay_nhap }}</td>
                                        <td>{{ $phieu->khoHang->ten_kho }}</td>
                                        <td>{{ $phieu->sanPham->ten_sp }}</td>
                                        <td>{{ $phieu->so_luong_nhap }}</td>
                                        <td>{{ number_format($phieu->gia_nhap, 0, ',', '.') }}</td>
                                        <td>{{ number_format($phieu->so_luong_nhap * $phieu->gia_nhap, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                                    <td>{{ $nhapKho->sum('so_luong_nhap') }}</td>
                                    <td></td>
                                    <td>{{ number_format($nhapKho->sum(fn($p) => $p->so_luong_nhap * $p->gia_nhap), 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <a href="{{ route('bao-cao.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection