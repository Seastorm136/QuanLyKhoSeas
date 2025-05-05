@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-6 fw-bold text-danger">Danh sách sản phẩm</h1>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-danger text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fs-4">Quản lý sản phẩm</h2>
                    <div>
                        <a href="{{ route('san-pham.create') }}" class="btn btn-light btn-sm me-2">
                            <i class="bi bi-plus-circle"></i> Thêm sản phẩm
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
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

                <form method="GET" action="{{ route('san-pham.index') }}" class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Tìm theo mã, tên hoặc loại sản phẩm" value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        <a href="{{ route('san-pham.index') }}" class="btn btn-outline-secondary">Xóa</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-nowrap">
                                    <a href="{{ route('san-pham.index', ['sort' => 'ma_sp', 'direction' => $sortColumn == 'ma_sp' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Mã SP @if($sortColumn == 'ma_sp') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="{{ route('san-pham.index', ['sort' => 'ten_sp', 'direction' => $sortColumn == 'ten_sp' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Tên SP @if($sortColumn == 'ten_sp') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col" class="text-nowrap">
                                    <a href="{{ route('san-pham.index', ['sort' => 'don_vi_tinh', 'direction' => $sortColumn == 'don_vi_tinh' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        ĐVT @if($sortColumn == 'don_vi_tinh') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col" class="text-nowrap">
                                    <a href="{{ route('san-pham.index', ['sort' => 'so_luong', 'direction' => $sortColumn == 'so_luong' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Số lượng @if($sortColumn == 'so_luong') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col" class="text-nowrap">
                                    <a href="{{ route('san-pham.index', ['sort' => 'gia_nhap', 'direction' => $sortColumn == 'gia_nhap' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Giá nhập @if($sortColumn == 'gia_nhap') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col" class="text-nowrap">
                                    <a href="{{ route('san-pham.index', ['sort' => 'ban_buon', 'direction' => $sortColumn == 'ban_buon' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Bán buôn @if($sortColumn == 'ban_buon') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col" class="text-nowrap">
                                    <a href="{{ route('san-pham.index', ['sort' => 'ban_le', 'direction' => $sortColumn == 'ban_le' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Bán lẻ @if($sortColumn == 'ban_le') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col" class="text-nowrap">
                                    <a href="{{ route('san-pham.index', ['sort' => 'loai_sp', 'direction' => $sortColumn == 'loai_sp' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Loại SP @if($sortColumn == 'loai_sp') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col" class="text-nowrap">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sanPhams as $sp)
                                <tr>
                                    <td>{{ $sp->ma_sp }}</td>
                                    <td>{{ $sp->ten_sp }}</td>
                                    <td>{{ $sp->don_vi_tinh }}</td>
                                    <td>
                                        <span class="badge {{ $sp->so_luong > 10 ? 'bg-success' : ($sp->so_luong > 0 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $sp->so_luong }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($sp->gia_nhap, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ number_format($sp->ban_buon, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ number_format($sp->ban_le, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $sp->loai_sp }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('san-pham.show', $sp->ma_sp) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('san-pham.edit', $sp->ma_sp) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('san-pham.destroy', $sp->ma_sp) }}" method="POST" style="display:inline;">
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
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="bi bi-box-seam me-2"></i> Chưa có sản phẩm nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">Tổng: {{ $sanPhams->total() }} sản phẩm</small>
                    </div>
                    {{ $sanPhams->appends(['sort' => $sortColumn, 'direction' => $sortDirection, 'search' => $search])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection