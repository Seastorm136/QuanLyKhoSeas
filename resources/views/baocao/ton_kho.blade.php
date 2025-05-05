@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white text-center">
                        <h2 class="mb-0 fs-4"><i class="bi bi-file-earmark-text me-2"></i>Báo cáo tồn kho</h2>
                    </div>
                    <div class="card-body">
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