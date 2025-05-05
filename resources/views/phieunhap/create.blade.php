@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tạo phiếu nhập</h1>
        <form method="POST" action="{{ route('phieu-nhap.store') }}">
            @csrf
            <div class="mb-3">
                <label for="ngay_nhap" class="form-label">Ngày nhập</label>
                <input type="date" name="ngay_nhap" id="ngay_nhap" class="form-control" value="{{ now()->toDateString() }}" required>
            </div>
            <div class="mb-3">
                <label for="ma_kho" class="form-label">Kho</label>
                <input type="text" class="form-control" value="{{ $khoHang->ten_kho }}" disabled>
            </div>
            <div class="mb-3">
                <label for="ma_sp" class="form-label">Sản phẩm</label>
                <select name="ma_sp" id="ma_sp" class="form-control" required onchange="updateGiaNhap()">
                    @foreach($sanPhams as $sp)
                        <option value="{{ $sp->ma_sp }}" data-gia-nhap="{{ $sp->gia_nhap }}">
                            {{ $sp->ten_sp }} (Tồn: {{ $sp->so_luong_ton }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="so_luong_nhap" class="form-label">Số lượng nhập</label>
                <input type="number" name="so_luong_nhap" id="so_luong_nhap" class="form-control" min="1" required>
            </div>
            <div class="mb-3">
                <label for="gia_nhap" class="form-label">Giá nhập</label>
                <input type="number" id="gia_nhap" class="form-control" readonly step="0.01" value="{{ $sanPhams->first()->gia_nhap ?? 0 }}">
                <input type="hidden" name="gia_nhap" id="gia_nhap_hidden" value="{{ $sanPhams->first()->gia_nhap ?? 0 }}">
            </div>
            <div class="mb-3">
                <label for="ma_nv" class="form-label">Nhân viên</label>
                <input type="hidden" name="ma_nv" value="{{ auth('staff')->user()->nhanVien->ma_nv }}">
                <input type="text" class="form-control" value="{{ auth('staff')->user()->nhanVien->ten_nv }}" disabled>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{ route('tao-phieu.warehouse_index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>

    <script>
        function updateGiaNhap() {
            const select = document.getElementById('ma_sp');
            const giaNhapInput = document.getElementById('gia_nhap');
            const giaNhapHidden = document.getElementById('gia_nhap_hidden');
            const selectedOption = select.options[select.selectedIndex];
            const giaNhap = selectedOption.getAttribute('data-gia-nhap');

            giaNhapInput.value = giaNhap;
            giaNhapHidden.value = giaNhap;
        }

        document.addEventListener('DOMContentLoaded', updateGiaNhap);
    </script>
@endsection