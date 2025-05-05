@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-6 fw-bold text-danger">Danh sách kho hàng</h1>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-danger text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fs-4">Quản lý kho hàng</h2>
                    <div>
                        <a href="{{ route('kho-hang.create') }}" class="btn btn-light btn-sm me-2">
                            <i class="bi bi-plus-circle"></i> Thêm kho hàng
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

                <form method="GET" action="{{ route('kho-hang.index') }}" class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Tìm theo mã, tên kho hoặc nhân viên" value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        <a href="{{ route('kho-hang.index') }}" class="btn btn-outline-secondary">Xóa</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-nowrap">
                                    <a href="{{ route('kho-hang.index', ['sort' => 'ma_kho', 'direction' => $sortColumn == 'ma_kho' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Mã kho @if($sortColumn == 'ma_kho') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="{{ route('kho-hang.index', ['sort' => 'ten_kho', 'direction' => $sortColumn == 'ten_kho' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Tên kho @if($sortColumn == 'ten_kho') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col" class="text-nowrap">Nhân viên</th>
                                <th scope="col" class="text-nowrap">Số lượng SP</th>
                                <th scope="col" class="text-nowrap">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($khoHangs as $kho)
                                <tr>
                                    <td>{{ $kho->ma_kho }}</td>
                                    <td>{{ $kho->ten_kho }}</td>
                                    <td>{{ $kho->nhanVien->ten_nv }}</td>
                                    <td>
                                        <span class="badge {{ $kho->so_luong_sp > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $kho->so_luong_sp }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('kho-hang.show', $kho->ma_kho) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('kho-hang.edit', $kho->ma_kho) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('kho-hang.destroy', $kho->ma_kho) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa kho này?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-box me-2"></i> Chưa có kho hàng nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">Tổng: {{ $khoHangs->total() }} kho hàng</small>
                    </div>
                    {{ $khoHangs->appends(['sort' => $sortColumn, 'direction' => $sortDirection, 'search' => $search])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection