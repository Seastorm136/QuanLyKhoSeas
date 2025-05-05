<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - SEAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 50px;
        }
        .login-header {
            background-color: #dc3545;
            color: white;
            text-align: center;
            padding: 15px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .login-body {
            padding: 20px;
            border: 1px solid #ddd;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .input-group-text {
            background-color: transparent;
            border: none;
        }
    </style>
</head>
<body>
    <header class="bg-primary text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">SEAS</h1>
        </div>
    </header>

    <div class="container login-container min-vh-100">
        <div class="card">
            <div class="login-header">
                <h2 class="mb-0">Đăng nhập</h2>
            </div>
            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="ten_dn" class="form-label">Tên đăng nhập</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" name="ten_dn" id="ten_dn" class="form-control @error('ten_dn') is-invalid @enderror" placeholder="Tên đăng nhập" value="{{ old('ten_dn') }}" required>
                            @error('ten_dn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mat_khau" class="form-label">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-unlock-fill"></i>
                            </span>
                            <input type="password" name="mat_khau" id="mat_khau" class="form-control @error('mat_khau') is-invalid @enderror" placeholder="Mật khẩu" required>
                            @error('mat_khau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">Nhớ tôi</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2">Đăng nhập</button>
                </form>
            </div>
        </div>
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