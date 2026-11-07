@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(180deg, var(--primary-50) 0%, #ffffff 100%); padding: 2.5rem 1rem;">
    <div style="width: 100%; max-width: 420px; background: #ffffff; padding: 2.5rem; border-radius: var(--radius-2xl); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid var(--neutral-200);">

        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="/" class="logo" style="justify-content: center; margin-bottom: 0.75rem;">
                <div class="logo-icon"><i class="fas fa-heartbeat"></i></div>
            </a>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--neutral-900);">Selamat Datang Kembali</h2>
            <p style="font-size: 0.85rem; color: var(--neutral-500); margin-top: 0.25rem;">Masuk ke akun MutiaraKesehatan Anda</p>
        </div>

        <form action="/login" method="POST" class="appointment-form">
            @csrf
            <div class="form-group" style="margin-bottom: 1.2rem;">
                <label class="form-label">Email / No. Telepon</label>
                <input type="email" name="email" class="form-input" placeholder="email@contoh.com" required autofocus style="width: 100%;">
            </div>

            <div class="form-group" style="margin-bottom: 1.2rem;" x-data="{ showPass: false }">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <label class="form-label" style="margin-bottom: 0;">Kata Sandi</label>
                    <a href="/forgot-password" style="font-size: 0.75rem; color: var(--primary-600); font-weight: 600;">Lupa Sandi?</a>
                </div>
                <div style="position: relative;">
                    <input :type="showPass ? 'text' : 'password'" name="password" class="form-input" placeholder="••••••••" required style="width: 100%; padding-right: 2.5rem;">
                    <button type="button" @click="showPass = !showPass" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--neutral-400); cursor: pointer;">
                        <i class="fas" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                <input type="checkbox" id="remember" name="remember" style="margin-right: 0.5rem; accent-color: var(--primary-500);">
                <label for="remember" style="font-size: 0.85rem; color: var(--neutral-600); cursor: pointer;">Ingat Saya</label>
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-full" style="width: 100%;">
                <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
            </button>
        </form>

        <div style="text-align: center; margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid var(--neutral-100); font-size: 0.85rem; color: var(--neutral-500);">
            Belum punya akun? <a href="/register" style="color: var(--primary-600); font-weight: 700;">Daftar Akun Baru</a>
        </div>

    </div>
</div>
@endsection
