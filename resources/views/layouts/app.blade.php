<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phần mềm quản lý kho - SEAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <header class="bg-primary text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">SEAS</h1>
            @if(auth('staff')->check() || auth('admin')->check())
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-list"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        @if(auth('admin')->check())
                            <li><a class="dropdown-item" href="{{ route('password.admin_change') }}">Đổi mật khẩu</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Đăng xuất</button>
                                </form>
                            </li>
                        @elseif(auth('staff')->check())
                            <li><a class="dropdown-item" href="{{ route('nhan-vien.staff_index') }}">Thông tin tài khoản</a></li>
                            @if(auth('staff')->user()->nhanVien && auth('staff')->user()->nhanVien->chuc_vu === 'Nhân viên kho')
                                <li><a class="dropdown-item" href="{{ route('password.staff_warehouse_change') }}">Đổi mật khẩu</a></li>
                            @elseif(auth('staff')->user()->nhanVien && auth('staff')->user()->nhanVien->chuc_vu === 'Nhân viên bán hàng')
                                <li><a class="dropdown-item" href="{{ route('password.staff_store_change') }}">Đổi mật khẩu</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Đăng xuất</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </header>

    <div class="container mt-4 min-vh-100">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('errors')->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <footer class="bg-dark text-white p-3 mt-4">
        <div class="container fs-6">
            <div class="row">
                <div class="col-md-6">
                    <p>{{ config('app_info.title') }} - Version {{ config('app_info.version') }}</p>
                    <p>{{ config('app_info.copyright') }}</p>
                    <p>Owner: {{ config('app_info.owner') }}</p>
                    <p>Contributor: {{ config('app_info.contributor') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>Email: <a href="mailto:{{ config('app_info.email') }}" class="text-white">{{ config('app_info.email') }}</a></p>
                    <p>Release: {{ config('app_info.release') }}</p>
                    <p>Timezone: {{ config('app_info.timezone') }}</p>
                    <p>App URL: <a href="{{ config('app_info.app_url') }}" class="text-white">{{ config('app_info.app_url') }}</a></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>