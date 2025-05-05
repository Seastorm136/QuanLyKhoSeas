@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 fs-4"><i class="bi bi-plus-circle me-2"></i>Thêm hóa đơn mới</h2>
                        <a href="{{ route('hoa-don.staff_index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>

                    <div class="card-body">
                        @if ($sanPhams->isEmpty())
                            <div class="alert alert-warning text-center">
                                <i class="bi bi-exclamation-triangle me-2"></i>Không có sản phẩm nào để lập hóa đơn.
                            </div>
                        @else
                            <form method="POST" action="{{ route('hoa-don.store') }}" id="hoaDonForm">
                                @csrf
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                                    </div>
                                @endif

                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <label for="ngay_lap" class="form-label fw-bold">Ngày lập</label>
                                        <input type="date" name="ngay_lap" id="ngay_lap"
                                               class="form-control @error('ngay_lap') is-invalid @enderror"
                                               value="{{ old('ngay_lap', now()->format('Y-m-d')) }}" required>
                                        @error('ngay_lap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="ma_nv" class="form-label fw-bold">Nhân viên lập</label>
                                        <input type="text" class="form-control"
                                               value="{{ auth('staff')->user()->nhanVien->ten_nv }}" readonly>
                                        <input type="hidden" name="ma_nv"
                                               value="{{ auth('staff')->user()->nhanVien->ma_nv }}">
                                        @error('ma_nv')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Chi tiết hóa đơn</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="productsTable">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th style="width: 25%;">Sản phẩm</th>
                                                    <th style="width: 15%;">Loại giá</th>
                                                    <th style="width: 15%;">Số lượng</th>
                                                    <th style="width: 20%;">Đơn giá (VNĐ)</th>
                                                    <th style="width: 20%;">Thành tiền (VNĐ)</th>
                                                    <th style="width: 5%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="products[0][ma_sp]"
                                                                class="form-select product-select @error('products.0.ma_sp') is-invalid @enderror"
                                                                required>
                                                            <option value="">Chọn sản phẩm</option>
                                                            @foreach ($sanPhams as $sp)
                                                                <option value="{{ $sp->ma_sp }}"
                                                                        data-ban-buon="{{ $sp->ban_buon }}"
                                                                        data-ban-le="{{ $sp->ban_le }}"
                                                                        data-ton-kho="{{ $sp->chiTietCuaHang->first()->so_luong ?? 0 }}"
                                                                        {{ old('products.0.ma_sp') == $sp->ma_sp ? 'selected' : '' }}>
                                                                    {{ $sp->ten_sp }} ({{ $sp->ma_sp }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('products.0.ma_sp')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <select name="products[0][loai_gia]"
                                                                class="form-select loai-gia @error('products.0.loai_gia') is-invalid @enderror"
                                                                required>
                                                            <option value="ban_le" {{ old('products.0.loai_gia') == 'ban_le' ? 'selected' : '' }}>Bán lẻ</option>
                                                            <option value="ban_buon" {{ old('products.0.loai_gia') == 'ban_buon' ? 'selected' : '' }}>Bán buôn</option>
                                                        </select>
                                                        @error('products.0.loai_gia')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" name="products[0][so_luong]"
                                                               class="form-control so-luong @error('products.0.so_luong') is-invalid @enderror"
                                                               min="1" value="{{ old('products.0.so_luong', 1) }}"
                                                               required>
                                                        @error('products.0.so_luong')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" name="products[0][don_gia]"
                                                               class="form-control don-gia @error('products.0.don_gia') is-invalid @enderror"
                                                               readonly required>
                                                        @error('products.0.don_gia')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" name="products[0][thanh_tien]"
                                                               class="form-control thanh-tien @error('products.0.thanh_tien') is-invalid @enderror"
                                                               readonly required>
                                                        @error('products.0.thanh_tien')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                class="btn btn-danger btn-sm remove-row">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end fw-bold">Tổng tiền:</td>
                                                    <td>
                                                        <input type="number" id="tong_tien" class="form-control fw-bold"
                                                               readonly>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm mt-2" id="addRow">
                                        <i class="bi bi-plus me-2"></i>Thêm sản phẩm
                                    </button>
                                    @error('products')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-2"></i>Lưu hóa đơn
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let rowIndex = 1;

        document.getElementById('addRow').addEventListener('click', function () {
            const tbody = document.querySelector('#productsTable tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <select name="products[${rowIndex}][ma_sp]" class="form-select product-select" required>
                        <option value="">Chọn sản phẩm</option>
                        @foreach ($sanPhams as $sp)
                            <option value="{{ $sp->ma_sp }}"
                                    data-ban-buon="{{ $sp->ban_buon }}"
                                    data-ban-le="{{ $sp->ban_le }}"
                                    data-ton-kho="{{ $sp->chiTietCuaHang->first()->so_luong ?? 0 }}">
                                {{ $sp->ten_sp }} ({{ $sp->ma_sp }})
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="products[${rowIndex}][loai_gia]" class="form-select loai-gia" required>
                        <option value="ban_le">Bán lẻ</option>
                        <option value="ban_buon">Bán buôn</option>
                    </select>
                </td>
                <td>
                    <input type="number" name="products[${rowIndex}][so_luong]" class="form-control so-luong" min="1" value="1" required>
                </td>
                <td>
                    <input type="number" name="products[${rowIndex}][don_gia]" class="form-control don-gia" readonly required>
                </td>
                <td>
                    <input type="number" name="products[${rowIndex}][thanh_tien]" class="form-control thanh-tien" readonly required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
            attachEventListeners(row);
            rowIndex++;
        });

        function attachEventListeners(row) {
            const productSelect = row.querySelector('.product-select');
            const loaiGiaSelect = row.querySelector('.loai-gia');
            const soLuongInput = row.querySelector('.so-luong');
            const donGiaInput = row.querySelector('.don-gia');
            const thanhTienInput = row.querySelector('.thanh-tien');
            const removeButton = row.querySelector('.remove-row');

            function updateDonGia() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const loaiGia = loaiGiaSelect.value;
                const banBuon = parseFloat(selectedOption.getAttribute('data-ban-buon')) || 0;
                const banLe = parseFloat(selectedOption.getAttribute('data-ban-le')) || 0;
                donGiaInput.value = loaiGia === 'ban_buon' ? banBuon : banLe;
                calculateThanhTien();
            }

            function calculateThanhTien() {
                const soLuong = parseInt(soLuongInput.value) || 0;
                const donGia = parseFloat(donGiaInput.value) || 0;
                const tonKho = parseInt(productSelect.options[productSelect.selectedIndex]?.getAttribute('data-ton-kho')) || 0;
                if (soLuong > tonKho && tonKho > 0) {
                    alert(`Số lượng vượt quá tồn kho! Tồn kho hiện tại: ${tonKho}`);
                    soLuongInput.value = tonKho;
                } else if (soLuong <= 0) {
                    soLuongInput.value = 1;
                }
                thanhTienInput.value = (soLuong * donGia).toFixed(2);
                calculateTongTien();
            }

            function calculateTongTien() {
                const thanhTiens = document.querySelectorAll('.thanh-tien');
                let tongTien = 0;
                thanhTiens.forEach(input => tongTien += parseFloat(input.value) || 0);
                document.getElementById('tong_tien').value = tongTien.toFixed(2);
            }

            productSelect.addEventListener('change', updateDonGia);
            loaiGiaSelect.addEventListener('change', updateDonGia);
            soLuongInput.addEventListener('input', calculateThanhTien);
            removeButton.addEventListener('click', function () {
                row.remove();
                calculateTongTien();
            });

            updateDonGia();
        }

        document.querySelectorAll('#productsTable tbody tr').forEach(attachEventListeners);
    </script>
@endsection