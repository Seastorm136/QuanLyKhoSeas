@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white text-center">
                        <h2 class="mb-0 fs-4"><i class="bi bi-file-earmark-text me-2"></i>Báo cáo xuất kho</h2>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('bao-cao.xuat_kho') }}" class="mb-3">
                            <div class="row">
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
                                    <button type="submit" name="export" value="excel" class="btn btn-success w-50"><i class="bi bi-file-earmark-excel me-2"></i>Xuất Excel</button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Mã phiếu xuất</th>
                                    <th>Ngày xuất</th>
                                    <th>Kho</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng xuất</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($xuatKho as $phieu)
                                    <tr>
                                        <td>{{ $phieu->ma_phieu_xuat }}</td>
                                        <td>{{ $phieu->ngay_xuat }}</td>
                                        <td>{{ $phieu->khoHang->ten_kho }}</td>
                                        <td>{{ $phieu->sanPham->ten_sp }}</td>
                                        <td>{{ $phieu->so_luong_xuat }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                                    <td>{{ $xuatKho->sum('so_luong_xuat') }}</td>
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