@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-6 fw-bold text-danger">{{ $cuaHang->ten_cua_hang }}</h1>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-danger text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fs-4">Danh sách sản phẩm</h2>
                    <div>
                        <a href="{{ route('chi-tiet-cua-hang.create', $cuaHang->ma_cua_hang) }}" class="btn btn-light btn-sm me-2">
                            <i class="bi bi-plus-circle"></i> Thêm sản phẩm
                        </a>
                        <a href="{{ route('cua-hang.index') }}" class="btn btn-light btn-sm">
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

                <form method="GET" action="{{ route('cua-hang.show', $cuaHang->ma_cua_hang) }}" class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Tìm theo mã SP hoặc tên SP" value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        <a href="{{ route('cua-hang.show', $cuaHang->ma_cua_hang) }}" class="btn btn-outline-secondary">Xóa</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-nowrap">
                                    <a href="{{ route('cua-hang.show', [$cuaHang->ma_cua_hang, 'sort' => 'ma_sp', 'direction' => $sortColumn == 'ma_sp' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Mã SP @if($sortColumn == 'ma_sp') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col">Tên SP</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col" class="text-nowrap">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($chiTietCuaHangs as $chiTiet)
                                <tr>
                                    <td>{{ $chiTiet->ma_sp }}</td>
                                    <td>{{ $chiTiet->sanPham->ten_sp }}</td>
                                    <td>
                                        <span class="badge {{ $chiTiet->so_luong > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $chiTiet->so_luong }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('san-pham.admin_store_show', [$chiTiet->ma_cua_hang, $chiTiet->ma_sp]) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('chi-tiet-cua-hang.edit', [$chiTiet->ma_cua_hang, $chiTiet->ma_sp]) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('chi-tiet-cua-hang.destroy', [$chiTiet->ma_cua_hang, $chiTiet->ma_sp]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa sản phẩm này?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-shop me-2"></i> Chưa có sản phẩm nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">Tổng: {{ $chiTietCuaHangs->total() }} sản phẩm trong cửa hàng</small>
                    </div>
                    {{ $chiTietCuaHangs->appends(['sort' => $sortColumn, 'direction' => $sortDirection, 'search' => $search])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection