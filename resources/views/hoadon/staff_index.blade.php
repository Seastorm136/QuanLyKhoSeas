@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-6 fw-bold text-danger">Danh sách hóa đơn</h1>
                <p class="lead">{{ $cuaHang->ten_cua_hang }}</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-danger text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fs-4">Quản lý hóa đơn</h2>
                    <div>
                        <a href="{{ route('hoa-don.create') }}" class="btn btn-light btn-sm me-2">
                            <i class="bi bi-plus-circle"></i> Thêm hóa đơn
                        </a>
                        <a href="{{ route('home_store') }}" class="btn btn-light btn-sm">
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

                <form method="GET" action="{{ route('hoa-don.staff_index') }}" class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Tìm theo mã, ngày lập" value="{{ request('search') ?? '' }}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        <a href="{{ route('hoa-don.staff_index') }}" class="btn btn-outline-secondary">Xóa</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">
                                    <a href="{{ route('hoa-don.staff_index', ['sort' => 'ma_hoa_don', 'direction' => $sortColumn == 'ma_hoa_don' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="text-white text-decoration-none">
                                        Mã hóa đơn @if($sortColumn == 'ma_hoa_don') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="{{ route('hoa-don.staff_index', ['sort' => 'ngay_lap', 'direction' => $sortColumn == 'ngay_lap' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="text-white text-decoration-none">
                                        Ngày lập @if($sortColumn == 'ngay_lap') {{ $sortDirection == 'asc' ? '↑' : '↓' }} @endif
                                    </a>
                                </th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hoaDons as $hoaDon)
                                <tr>
                                    <td>{{ $hoaDon->ma_hoa_don }}</td>
                                    <td>{{ \Carbon\Carbon::parse($hoaDon->ngay_lap)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ number_format($hoaDon->tong_tien, 0, ',', '.') }} VNĐ
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('hoa-don.staff_show', $hoaDon->ma_hoa_don) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('hoa-don.edit', $hoaDon->ma_hoa_don) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('hoa-don.destroy', $hoaDon->ma_hoa_don) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa hóa đơn này?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-receipt me-2"></i> Chưa có hóa đơn nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">Tổng: {{ $hoaDons->total() }} hóa đơn</small>
                    </div>
                    {{ $hoaDons->appends(['sort' => $sortColumn, 'direction' => $sortDirection, 'search' => request('search')])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection