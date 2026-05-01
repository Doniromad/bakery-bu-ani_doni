<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bakery Bu Ani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary-blue: #4A90E2;    
            --dark-blue:    #357ABD;    
            --soft-blue:    #F0F7FF;    
            --slate-dark:   #1E293B;    
            --slate-mid:    #475569;    
            --white:        #FFFFFF;
            --danger:       #D06060;
            --success:      #2E6B3A;
            --radius-card:  24px;
            --radius-input: 12px;
            --shadow-card:  0 20px 50px rgba(74, 144, 226, 0.12);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--soft-blue);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
        }

        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }
        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(74, 144, 226, 0.08) 0%, transparent 70%);
            top: -100px; left: -150px;
        }
        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(53, 122, 189, 0.06) 0%, transparent 70%);
            bottom: -100px; right: -100px;
        }

        .bg-pattern {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Ccircle cx='40' cy='40' r='28' fill='%234A90E2'/%3E%3C/svg%3E");
            background-size: 60px 60px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        .card-main {
            background: var(--white);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(74, 144, 226, 0.1);
            overflow: hidden;
            animation: slideUp 0.6s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-hero {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-body-custom {
            padding: 40px 36px 30px;
        }

        .form-label-custom {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--slate-dark);
            margin-bottom: 8px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 22px;
        }
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-mid);
            font-size: 1.1rem;
            z-index: 2;
        }
        .form-input {
            width: 100%;
            padding: 13px 16px 13px 48px;
            border: 1.5px solid #E2E8F0;
            border-radius: var(--radius-input);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            color: var(--slate-dark);
            background: #F8FAFC;
            transition: all 0.25s ease;
            outline: none;
        }
        .form-input:focus {
            border-color: var(--primary-blue);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.1);
        }

        .pw-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: var(--slate-mid);
            cursor: pointer;
            z-index: 2;
        }

        .row-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .check-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.875rem; color: var(--slate-mid);
            cursor: pointer;
        }
        .check-label input { accent-color: var(--primary-blue); }
        
        .link-blue {
            color: var(--primary-blue);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .link-blue:hover { text-decoration: underline; }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            border-radius: var(--radius-input);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 25px;
        }
        .btn-submit:hover {
            background: var(--dark-blue);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(74, 144, 226, 0.25);
        }

        .card-footer-custom {
            background: #F8FAFC;
            border-top: 1px solid #EDF2F7;
            padding: 20px 36px;
            text-align: center;
        }
        .card-footer-custom a {
            color: var(--slate-mid);
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .card-footer-custom a:hover { color: var(--primary-blue); }

        .register-row { text-align: center; font-size: 0.9rem; color: var(--slate-mid); }
        .register-row a { color: var(--primary-blue); font-weight: 600; text-decoration: none; }

        @media (max-width: 480px) {
            .card-hero { padding: 35px 24px; }
            .card-body-custom { padding: 30px 24px; }
        }
    </style>
</head>
<body>
<div class="bg-pattern"></div>

<div class="login-wrapper">
    <div class="card-main">

        <div class="card-hero">
            {{-- Container Logo & Tulisan disusun secara vertikal (Stacked) --}}
            <div class="d-flex flex-column align-items-center justify-content-center">
                
                {{-- LOGO BULAT PENUH --}}
                <div style="width: 80px; height: 80px; background: white; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 15px rgba(0,0,0,0.15); border: 3px solid white; margin-bottom: 15px;">
                    <img src="{{ asset('images/logo-toko.png') }}" 
                         alt="Logo" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                {{-- TULISAN RATA TENGAH --}}
                <div class="text-center">
                    <h4 class="fw-bold m-0" style="color: white; font-family: 'Playfair Display', serif; line-height: 1.2; font-size: 1.8rem;">
                        Bakery Bu Ani
                    </h4>
                    <p class="m-0 mt-1" style="color: rgba(255,255,255,0.85); font-size: 0.85rem;">
                        Selamat datang kembali!
                    </p>
                </div>
            </div>
        </div>

        <div class="card-body-custom">
            @if(session('status'))
                <div class="alert alert-success d-flex align-items-center" style="font-size: 0.85rem; border-radius: 10px;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-center" style="font-size: 0.85rem; border-radius: 10px;">
                    <i class="bi bi-exclamation-circle-fill me-2"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="form-label-custom">Email</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" id="email" name="email"
                               class="form-input" value="{{ old('email') }}"
                               placeholder="nama@email.com" required autofocus>
                    </div>
                </div>

                <div>
                    <label for="password" class="form-label-custom">Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" id="password" name="password"
                               class="form-input" placeholder="••••••••" required>
                        <button type="button" class="pw-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="row-meta">
                    <label class="check-label">
                        <input type="checkbox" name="remember"> Ingat saya
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-blue">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                     Masuk
                </button>

                <div class="register-row">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                </div>
            </form>
        </div>

        <div class="card-footer-custom">
            <a href="{{ route('home') }}">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>
</body>
</html>