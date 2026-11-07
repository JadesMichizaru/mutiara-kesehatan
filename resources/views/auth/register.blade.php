@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(180deg, var(--primary-50) 0%, #ffffff 100%); padding: 2.5rem 1rem;">
    <div style="width: 100%; max-width: 480px; background: #ffffff; padding: 2.5rem; border-radius: var(--radius-2xl); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid var(--neutral-200);">

        <!-- Logo Header -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="/" class="logo" style="justify-content: center; margin-bottom: 0.75rem;">
                <div class="logo-icon"><i class="fas fa-heartbeat"></i></div>
            </a>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--neutral-900);">Pendaftaran Akun Pasien</h2>
            <p style="font-size: 0.85rem; color: var(--neutral-500); margin-top: 0.25rem;">Buat akun untuk riwayat berobat & janji temu online</p>
        </div>

        <!-- Form Register -->
        <form action="/register" method="POST" class="appointment-form">
            @csrf

            <!-- Nama Lengkap -->
            <div class="form-group" style="margin-bottom: 1.2rem;">
                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="name" class="form-input" placeholder="Masukkan nama sesuai KTP" required autofocus style="width: 100%;">
            </div>

            <!-- Email & Phone -->
            <div class="form-row" style="grid-template-columns: 1fr 1fr; margin-bottom: 1.2rem;">
                <div class="form-group">
                    <label class="form-label">Email <span class="required">*</span></label>
                    <input type="email" name="email" class="form-input" placeholder="email@contoh.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">No. Telepon/WA <span class="required">*</span></label>
                    <input type="tel" name="phone_number" class="form-input" placeholder="08xxxxxxxxxx" required>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group" style="margin-bottom: 1.2rem;" x-data="{ showPass: false }">
                <label class="form-label">Kata Sandi <span class="required">*</span></label>
                <div style="position: relative;">
                    <input :type="showPass ? 'text' : 'password'" name="password" class="form-input" placeholder="Minimal 8 karakter" required style="width: 100%; padding-right: 2.5rem;">
                    <button type="button" @click="showPass = !showPass" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--neutral-400); cursor: pointer;">
                        <i class="fas" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label">Konfirmasi Kata Sandi <span class="required">*</span></label>
                <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi kata sandi" required style="width: 100%;">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-lg btn-full" style="width: 100%;">
                <i class="fas fa-user-plus"></i> Buat Akun Pasien
            </button>
        </form>

        <!-- Login Link -->
        <div style="text-align: center; margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid var(--neutral-100); font-size: 0.85rem; color: var(--neutral-500);">
            Sudah memiliki akun? <a href="/login" style="color: var(--primary-600); font-weight: 700;">Masuk di Sini</a>
        </div>

    </div>
</div>
@endsection
