<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Toko Roti Ibu Ani</title>
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
            padding: 40px 16px;
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

        .register-wrapper {
            width: 100%;
            max-width: 480px;
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
            padding: 40px 36px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* CONTAINER LOGO SESUAI LOGIN */
        .hero-logo-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 90px; height: 90px;
            background: #FFFFFF;
            border-radius: 20px;
            margin-bottom: 16px;
            padding: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .hero-logo-wrap img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--white);
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .hero-sub {
            color: rgba(255,255,255,0.85);
            font-size: 0.9rem;
            font-weight: 300;
        }

        .steps-bar {
            background: #F8FAFC;
            padding: 14px 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-bottom: 1px solid #EDF2F7;
        }
        .step-dot {
            width: 32px; height: 5px;
            border-radius: 10px;
            background: #E2E8F0;
        }
        .step-dot.active { background: var(--primary-blue); }
        .step-label {
            font-size: 0.75rem;
            color: var(--slate-mid);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .card-body-custom {
            padding: 36px 36px 30px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--slate-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #F1F5F9;
            display: flex;
            align-items: center;
            gap: 10px;
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
            margin-bottom: 20px;
        }
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-mid);
            font-size: 1.05rem;
            z-index: 2;
        }
        .form-input {
            width: 100%;
            padding: 13px 16px 13px 48px;
            border: 1.5px solid #E2E8F0;
            border-radius: var(--radius-input);
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

        .pw-strength { margin-bottom: 20px; }
        .pw-strength-bar {
            height: 5px;
            border-radius: 10px;
            background: #E2E8F0;
            overflow: hidden;
            margin-bottom: 6px;
        }
        .pw-strength-fill {
            height: 100%; width: 0%;
            transition: all 0.4s ease;
        }
        .pw-strength-text { font-size: 0.75rem; font-weight: 500; }

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
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
        }
        .btn-submit:hover {
            background: var(--dark-blue);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(74, 144, 226, 0.25);
        }

        .terms-text {
            font-size: 0.8rem;
            color: var(--slate-mid);
            text-align: center;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .terms-text a { color: var(--primary-blue); text-decoration: none; font-weight: 600; }

        .login-row { text-align: center; font-size: 0.9rem; color: var(--slate-mid); }
        .login-row a { color: var(--primary-blue); font-weight: 600; text-decoration: none; }

        .card-footer-custom {
            background: #F8FAFC;
            border-top: 1px solid #EDF2F7;
            padding: 18px 36px;
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

        @media (max-width: 480px) {
            .card-hero { padding: 32px 20px; }
            .card-body-custom { padding: 28px 24px; }
            .hero-title { font-size: 1.4rem; }
            .hero-logo-wrap { width: 75px; height: 75px; }
        }
    </style>
</head>
<body>
<div class="bg-pattern"></div>

<div class="register-wrapper">
    <div class="card-main">

        <div class="card-hero" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); padding: 40px 36px 32px; text-align: center; border-radius: 20px 20px 0 0;">
    
    {{-- LOGO DI ATAS: Bulat Sempurna & Full --}}
    <div style="display: inline-flex; align-items: center; justify-content: center; width: 80px; height: 80px; background: white; border-radius: 50%; margin-bottom: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden; border: 2px solid white;">
        <img src="{{ asset('images/logo-toko.png') }}" 
             alt="Logo Toko Roti Ibu Ani" 
             style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    {{-- TULISAN DI BAWAH --}}
    <h1 class="hero-title" style="font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700; color: white; line-height: 1.2; margin-bottom: 6px;">
        Bergabung Sekarang
    </h1>
    <p class="hero-sub" style="color: rgba(255,255,255,0.85); font-size: 0.9rem; font-weight: 300; margin: 0;">
        Nikmati roti segar setiap hari bersama kami.
    </p>
</div>

        <div class="steps-bar">
            <div class="step-dot active"></div>
            <div class="step-dot active"></div>
            <div class="step-dot"></div>
            <span class="step-label" style="margin-left:8px;">Akun Baru</span>
        </div>

        <div class="card-body-custom">
            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-start" style="font-size: 0.85rem; border-radius: 12px; border: none;">
                    <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <p class="section-title">
                    <i class="bi bi-person-badge" style="color:var(--primary-blue);"></i>
                    Identitas Diri
                </p>

                <div>
                    <label for="name" class="form-label-custom">Nama Lengkap</label>
                    <div class="input-group-custom">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" id="name" name="name" 
                               class="form-input" value="{{ old('name') }}" 
                               placeholder="Nama lengkap Anda" required autofocus>
                    </div>
                </div>

                <div>
                    <label for="email" class="form-label-custom">Email</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" id="email" name="email" 
                               class="form-input" value="{{ old('email') }}" 
                               placeholder="nama@email.com" required>
                    </div>
                </div>

                <p class="section-title" style="margin-top: 30px;">
                    <i class="bi bi-key" style="color:var(--primary-blue);"></i>
                    Keamanan
                </p>

                <div>
                    <label for="password" class="form-label-custom">Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" id="password" name="password" 
                               class="form-input" placeholder="Minimal 8 karakter" 
                               required oninput="checkStrength(this.value)">
                        <button type="button" class="pw-toggle" onclick="togglePw('password','icon1')">
                            <i class="bi bi-eye" id="icon1"></i>
                        </button>
                    </div>
                    
                    <div class="pw-strength" id="strengthWrap" style="display:none;">
                        <div class="pw-strength-bar">
                            <div class="pw-strength-fill" id="strengthFill"></div>
                        </div>
                        <span class="pw-strength-text" id="strengthLabel"></span>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="form-label-custom">Konfirmasi Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="form-input" placeholder="Ulangi password" required>
                        <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation','icon2')">
                            <i class="bi bi-eye" id="icon2"></i>
                        </button>
                    </div>
                </div>

                <p class="terms-text">
                    Dengan mendaftar, Anda menyetujui <a href="#">Syarat & Ketentuan</a> serta <a href="#">Kebijakan Privasi</a> kami.
                </p>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-person-plus"></i> Daftar Sekarang
                </button>

                <div class="login-row">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </form>
        </div>

        <div class="card-footer-custom">
            <a href="{{ route('home') }}">
                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

<script>
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

function checkStrength(val) {
    const wrap  = document.getElementById('strengthWrap');
    const fill  = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    
    if (!val) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'block';
    
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    
    const levels = [
        { pct: '20%', color: '#D06060', text: 'Sangat lemah' },
        { pct: '40%', color: '#E07030', text: 'Lemah' },
        { pct: '65%', color: '#4A90E2', text: 'Sedang' },
        { pct: '85%', color: '#357ABD', text: 'Kuat' },
        { pct: '100%',color: '#2E6B3A', text: 'Sangat kuat' },
    ];
    
    const lvl = levels[Math.min(score, 4)];
    fill.style.width = lvl.pct;
    fill.style.background = lvl.color;
    label.textContent = lvl.text;
    label.style.color = lvl.color;
}
</script>
</body>
</html>