DOKUMENTASI IMPLEMENTASI GOOGLE LOGIN (OAuth)
================================================

📋 LANGKAH-LANGKAH SETUP:

1. KONFIGURASI GOOGLE CONSOLE
   ==========================
   
   a. Buka https://console.cloud.google.com/
   b. Buat project baru (jika belum ada)
   c. Aktifkan Google+ API:
      - Klik "Enable APIs and Services"
      - Cari "Google+ API"
      - Klik Enable
   
   d. Buat OAuth 2.0 Credentials:
      - Klik "Create Credentials" → "OAuth client ID"
      - Pilih "Web application"
      - Nama: "Toko Roti App" (atau sesuai aplikasi Anda)
      - Authorized JavaScript origins: 
        * http://localhost:8000 (development)
        * http://127.0.0.1:8000 (development)
        * https://yourdomain.com (production)
      - Authorized redirect URIs:
        * http://localhost:8000/auth/google/callback (development)
        * https://yourdomain.com/auth/google/callback (production)
      - Klik Create
   
   e. Copy Client ID dan Client Secret

2. KONFIGURASI .env
   ================
   
   Tambahkan baris berikut di file .env Anda:
   
   # Google OAuth
   GOOGLE_CLIENT_ID=your-client-id-here.apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=your-client-secret-here
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   
   CATATAN:
   - Ganti your-client-id-here dengan Client ID dari Google Console
   - Ganti your-client-secret-here dengan Client Secret dari Google Console
   - GOOGLE_REDIRECT_URI harus sama dengan yang Anda daftarkan di Google Console
   - Untuk production, ubah localhost menjadi domain Anda

3. VERIFIKASI KONFIGURASI
   =======================
   
   a. services.php sudah memiliki:
      'google' => [
          'client_id' => env('GOOGLE_CLIENT_ID'),
          'client_secret' => env('GOOGLE_CLIENT_SECRET'),
          'redirect' => env('GOOGLE_REDIRECT_URI'),
      ],
   
   b. Routes sudah ditambahkan:
      Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
      Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
   
   c. Controller GoogleController.php sudah dibuat dengan logic:
      - Redirect ke Google
      - Handle callback
      - Cek apakah email sudah terdaftar
      - Update google_id jika sudah ada, atau create user baru
      - Auto-login setelah berhasil

4. IMPLEMENTASI DI VIEW LOGIN
   ===========================
   
   Tambahkan tombol Google di file resources/views/auth/login.blade.php:
   
   <div class="mt-4">
       <a href="{{ route('auth.google') }}" class="btn btn-outline-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-2">
           <img src="https://www.gstatic.com/firebaseapp/v8_14_0/images/google.svg" 
                alt="Google" 
                style="width: 20px; height: 20px;">
           <span>Lanjutkan dengan Google</span>
       </a>
   </div>
   
   Lihat file CONTOH_VIEW_TOMBOL_GOOGLE.blade.php untuk alternatif styling lainnya

5. DATABASE MIGRATION CHECK
   ========================
   
   Pastikan migrations sudah berjalan:
   
   a. Kolom google_id sudah ada di tabel users ✓
   b. Password nullable ✓
   c. Field dalam $fillable di User.php sudah include google_id ✓
   
   Jika belum, jalankan:
   php artisan migrate

6. TESTING
   =======
   
   a. Jalankan development server:
      php artisan serve
   
   b. Buka http://localhost:8000/login (atau halaman login Anda)
   
   c. Klik tombol "Lanjutkan dengan Google"
   
   d. Login dengan akun Google Anda
   
   e. Jika berhasil, Anda akan di-redirect ke home
   
   f. Jika error, cek:
      - GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di .env
      - GOOGLE_REDIRECT_URI sesuai dengan route callback
      - Pastikan Google OAuth credentials sudah aktif

7. TROUBLESHOOTING
   ================
   
   ERROR: "Redirect URI mismatch"
   → Pastikan GOOGLE_REDIRECT_URI di .env sama persis dengan 
     redirect URI di Google Console (termasuk http/https dan port)
   
   ERROR: "invalid_client"
   → Pastikan GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET benar
   → Cek di .env dan Google Console
   
   ERROR: "Failed to decode response body"
   → Pastikan laravel/socialite sudah diinstall: composer require laravel/socialite
   
   User tidak ter-login setelah callback
   → Cek apakah Auth::login() di GoogleController.php berjalan
   → Cek session configuration di config/session.php

8. FITUR TAMBAHAN (Optional)
   =========================
   
   a. Tambahkan profile picture dari Google:
      - Di migrations, tambahkan kolom: $table->string('profile_picture')->nullable();
      - Di User.php $fillable, tambahkan: 'profile_picture'
      - Di GoogleController, ubah create/update:
        'profile_picture' => $googleUser->getAvatar(),
   
   b. Simpan akses token Google:
      - Di migrations, tambahkan: $table->text('google_token')->nullable();
      - Di GoogleController: 'google_token' => $googleUser->token,
   
   c. Refresh token (untuk akses API Google):
      - Di migrations, tambahkan: $table->text('google_refresh_token')->nullable();
      - Simpan di controller untuk penggunaan mendatang

================================================
Semoga implementasi Google Login berjalan lancar! 
================================================
