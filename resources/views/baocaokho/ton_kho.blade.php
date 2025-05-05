@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-4">Báo cáo tồn kho</h1>
                <p class="lead">Kho: {{ $khoHang->ten_kho }}</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-4">
                    <form method="GET" action="{{ route('bao-cao-kho.ton_kho') }}">
                        <button type="submit" name="export" value="1" class="btn btn-success"><i class="bi bi-file-earmark-excel me-2"></i>Xuất Excel</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng tồn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tonKho as $item)
                                <tr>
                                    <td>{{ $item->sanPham->ten_sp }}</td>
                                    <td>{{ $item->so_luong }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Không có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-end fw-bold">Tổng cộng:</td>
                                <td>{{ $tonKho->sum('so_luong') }}</td>
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