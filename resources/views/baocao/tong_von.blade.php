@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-4">Báo cáo tổng vốn</h1>
                <p class="lead">Tổng vốn hiện tại và chi tiết vốn từng kho</p>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-wallet2 display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Tổng vốn</h5>
                        <p class="card-text">{{ number_format($tongVon, 2) }} VND</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-bank display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Vốn lưu động</h5>
                        <p class="card-text">{{ number_format($tongVonLuuDong, 2) }} VND</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-boxes display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Tổng vốn các kho</h5>
                        <p class="card-text">{{ number_format($tongVonKho, 2) }} VND</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-stack display-4 text-primary"></i>
                        <h5 class="card-title mt-3">Doanh thu tháng trước</h5>
                        <p class="card-text">{{ number_format($doanhThuBanHang, 2) }} VND</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Chi tiết vốn từng kho</h5>
                            <div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#themVonModal">
                                    <i class="bi bi-plus-circle me-2"></i>Thêm vốn ban đầu
                                </button>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#phanPhoiVonModal">
                                    <i class="bi bi-arrow-right-circle me-2"></i>Phân phối vốn
                                </button>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#rutVonModal">
                                    <i class="bi bi-arrow-left-circle me-2"></i>Rút vốn
                                </button>
                                <form method="GET" action="{{ route('bao-cao.tong_von') }}" class="d-inline">
                                    <button type="submit" name="export" value="excel" class="btn btn-success">
                                        <i class="bi bi-file-earmark-excel me-2"></i>Xuất Excel
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã kho</th>
                                        <th>Tên kho</th>
                                        <th>Vốn sẵn có</th>
                                        <th>Ngày cập nhật</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($danhSachVon as $von)
                                        <tr>
                                            <td>{{ $von->ma_kho }}</td>
                                            <td>{{ $von->kho->ten_kho ?? 'N/A' }}</td>
                                            <td>{{ number_format($von->tong_von, 2) }} VND</td>
                                            <td>{{ $von->ngay_cap_nhat ?? 'Chưa cập nhật' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Không có dữ liệu vốn kho</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                <a href="{{ route('bao-cao.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </div>

        <div class="modal fade" id="themVonModal" tabindex="-1" aria-labelledby="themVonModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="themVonModalLabel">Thêm vốn ban đầu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('bao-cao.them_von') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tong_von_them" class="form-label">Số vốn ban đầu (VND)</label>
                                <input type="number" step="0.01" class="form-control" id="tong_von_them" name="tong_von" min="0" required>
                                @error('tong_von')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Thêm vốn</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="phanPhoiVonModal" tabindex="-1" aria-labelledby="phanPhoiVonModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="phanPhoiVonModalLabel">Phân phối vốn từ vốn lưu động</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('bao-cao.phan_phoi_von') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="ma_kho_phan_phoi" class="form-label">Chọn kho</label>
                                <select class="form-select" id="ma_kho_phan_phoi" name="ma_kho" required>
                                    <option value="">-- Chọn kho --</option>
                                    @foreach (\App\Models\KhoHang::all() as $kho)
                                        <option value="{{ $kho->ma_kho }}">{{ $kho->ten_kho ?? $kho->ma_kho }}</option>
                                    @endforeach
                                </select>
                                @error('ma_kho')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="so_tien_phan_phoi" class="form-label">Số tiền phân phối (VND)</label>
                                <input type="number" step="0.01" class="form-control" id="so_tien_phan_phoi" name="so_tien_phan_phoi" min="0" required>
                                @error('so_tien_phan_phoi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-info">Phân phối</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="rutVonModal" tabindex="-1" aria-labelledby="rutVonModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rutVonModalLabel">Rút vốn về vốn lưu động</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('bao-cao.rut_von') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="ma_kho_rut" class="form-label">Chọn kho</label>
                                <select class="form-select" id="ma_kho_rut" name="ma_kho" required>
                                    <option value="">-- Chọn kho --</option>
                                    @foreach (\App\Models\KhoHang::all() as $kho)
                                        <option value="{{ $kho->ma_kho }}">{{ $kho->ten_kho ?? $kho->ma_kho }}</option>
                                    @endforeach
                                </select>
                                @error('ma_kho')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="so_tien_rut" class="form-label">Số tiền rút (VND)</label>
                                <input type="number" step="0.01" class="form-control" id="so_tien_rut" name="so_tien_rut" min="0" required>
                                @error('so_tien_rut')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-warning">Rút vốn</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection