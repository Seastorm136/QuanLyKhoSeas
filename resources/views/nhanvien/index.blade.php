@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-6 fw-bold text-danger">Danh sách nhân viên</h1>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-danger text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fs-4">Quản lý nhân viên</h2>
                    <div>
                        <a href="{{ route('nhan-vien.create') }}" class="btn btn-light btn-sm me-2">
                            <i class="bi bi-plus-circle"></i> Thêm nhân viên
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

                <form method="GET" action="{{ route('nhan-vien.index') }}" class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Tìm theo mã, tên hoặc SĐT" value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        <a href="{{ route('nhan-vien.index') }}" class="btn btn-outline-secondary">Xóa</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-nowrap">
                                    <a href="{{ route('nhan-vien.index', ['sort' => 'ma_nv', 'direction' => $sortColumn == 'ma_nv' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Mã NV @if($sortColumn == 'ma_nv') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="{{ route('nhan-vien.index', ['sort' => 'ten_nv', 'direction' => $sortColumn == 'ten_nv' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => $search]) }}" class="text-white text-decoration-none">
                                        Tên NV @if($sortColumn == 'ten_nv') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col" class="text-nowrap">Giới tính</th>
                                <th scope="col" class="text-nowrap">Ngày sinh</th>
                                <th scope="col" class="text-nowrap">SĐT</th>
                                <th scope="col" class="text-nowrap">Chức vụ</th>
                                <th scope="col" class="text-nowrap">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nhanViens as $nv)
                                <tr>
                                    <td>{{ $nv->ma_nv }}</td>
                                    <td>{{ $nv->ten_nv }}</td>
                                    <td>{{ $nv->gioitinh }}</td>
                                    <td>{{ $nv->ngay_sinh }}</td>
                                    <td>{{ $nv->so_dt }}</td>
                                    <td>
                                        <span class="badge {{ $nv->chuc_vu == 'Quản lý' ? 'bg-primary' : 'bg-secondary' }}">
                                            {{ $nv->chuc_vu }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('nhan-vien.show', $nv->ma_nv) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('nhan-vien.edit', $nv->ma_nv) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('nhan-vien.destroy', $nv->ma_nv) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa nhân viên này?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-person me-2"></i> Chưa có nhân viên nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">Tổng: {{ $nhanViens->total() }} nhân viên</small>
                    </div>
                    {{ $nhanViens->appends(['sort' => $sortColumn, 'direction' => $sortDirection, 'search' => $search])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection