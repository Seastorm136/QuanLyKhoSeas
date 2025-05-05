@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white text-center">
                        <h2 class="mb-0 fs-4"><i class="bi bi-file-earmark-text me-2"></i>Báo cáo hàng tồn đọng</h2>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('bao-cao.hang_ton_dong') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="days" class="form-label">Số ngày không giao dịch</label>
                                    <input type="number" name="days" id="days" class="form-control" value="{{ $days }}" min="1">
                                </div>
                                <div class="col-md-8 d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-primary w-50"><i class="bi bi-search me-2"></i>Lọc</button>
                                    <button type="submit" name="export" value="excel" class="btn btn-success w-50"><i class="bi bi-file-earmark-excel me-2"></i>Xuất Excel</button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Kho</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng tồn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tonKho as $item)
                                    <tr>
                                        <td>{{ $item->khoHang->ten_kho }}</td>
                                        <td>{{ $item->sanPham->ten_sp }}</td>
                                        <td>{{ $item->so_luong }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end fw-bold">Tổng cộng:</td>
                                    <td>{{ $tonKho->sum('so_luong') }}</td>
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