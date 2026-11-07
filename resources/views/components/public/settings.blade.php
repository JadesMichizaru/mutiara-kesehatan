<div class="mk-settings-wrapper">
    <div class="mk-container">

        <!-- Header Halaman -->
        <div class="mk-card mk-header-card">
            <div class="mk-header-profile">
                <div class="mk-avatar">
                    {{ strtoupper(substr($name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <h1 class="mk-title">Pengaturan Akun</h1>
                    <p class="mk-subtitle">
                        <span class="mk-pulse-dot"></span>
                        Portal Pengguna & Keamanan Medis
                    </p>
                </div>
            </div>
            <div class="mk-badge">
                <i class="fas fa-user-shield"></i> Terverifikasi
            </div>
        </div>

        <!-- Flash Message Success -->
        @if($success)
            <div class="mk-alert mk-alert-success">
                <div class="mk-alert-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="mk-alert-content">
                    <strong>Berhasil Diperbarui</strong>
                    <p>{{ $successMessage }}</p>
                </div>
                <button wire:click="$set('success', false)" class="mk-alert-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Grid Layout Content -->
        <div class="mk-grid">

            <!-- Sidebar Info Medis -->
            <aside class="mk-sidebar">
                <div class="mk-card mk-info-card">
                    <div class="mk-info-icon">
                        <i class="fas fa-hospital-user"></i>
                    </div>
                    <h3>Informasi Akun Medis</h3>
                    <p>Pastikan data identitas Anda selalu diperbarui untuk integrasi rekam medis dan koordinasi layanan klinik.</p>

                    <div class="mk-info-meta">
                        <div class="mk-meta-item">
                            <span>Status Akun</span>
                            <strong>Aktif</strong>
                        </div>
                        <div class="mk-meta-item">
                            <span>Keamanan Data</span>
                            <strong class="text-emerald">256-bit SSL</strong>
                        </div>
                        <div class="mk-meta-item">
                            <a href="/">Go to Home</a>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Form Utama -->
            <main class="mk-main-content">

                <!-- Form Profil -->
                <div class="mk-card">
                    <div class="mk-card-header">
                        <div class="mk-icon-box teal">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div>
                            <h2>Informasi Profil</h2>
                            <p>Perbarui nama dan email akun Anda</p>
                        </div>
                    </div>

                    <form wire:submit.prevent="updateProfile" class="mk-form">
                        <div class="mk-form-group">
                            <label for="name">Nama Lengkap <span class="required">*</span></label>
                            <div class="mk-input-icon-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input
                                    type="text"
                                    id="name"
                                    wire:model="name"
                                    class="mk-input @error('name') is-invalid @enderror"
                                    placeholder="Masukkan nama lengkap"
                                >
                            </div>
                            @error('name')
                                <span class="mk-error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mk-form-group">
                            <label for="email">Alamat Email <span class="required">*</span></label>
                            <div class="mk-input-icon-wrapper">
                                <i class="fas fa-envelope input-icon"></i>
                                <input
                                    type="email"
                                    id="email"
                                    wire:model="email"
                                    class="mk-input @error('email') is-invalid @enderror"
                                    placeholder="nama@domain.com"
                                >
                            </div>
                            @error('email')
                                <span class="mk-error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mk-form-actions">
                            <button type="submit" class="mk-btn mk-btn-teal" wire:loading.attr="disabled">
                                <span wire:loading.remove><i class="fas fa-save"></i> Simpan Profil</span>
                                <span wire:loading><i class="fas fa-circle-notch fa-spin"></i> Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Form Password -->
                <div class="mk-card">
                    <div class="mk-card-header justify-between">
                        <div class="flex-align">
                            <div class="mk-icon-box emerald">
                                <i class="fas fa-shield-halved"></i>
                            </div>
                            <div>
                                <h2>Keamanan Password</h2>
                                <p>Kelola kredensial kata sandi akun</p>
                            </div>
                        </div>
                        <button type="button" wire:click="togglePasswordForm" class="mk-btn-text">
                            {{ $showPasswordForm ? 'Batal' : 'Ubah Password' }}
                        </button>
                    </div>

                    @if($showPasswordForm)
                        <form wire:submit.prevent="updatePassword" class="mk-form">
                            <div class="mk-form-group">
                                <label for="current_password">Password Saat Ini <span class="required">*</span></label>
                                <input
                                    type="password"
                                    id="current_password"
                                    wire:model="current_password"
                                    class="mk-input @error('current_password') is-invalid @enderror"
                                    placeholder="Masukkan password saat ini"
                                >
                                @error('current_password')
                                    <span class="mk-error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mk-form-group">
                                <label for="new_password">Password Baru <span class="required">*</span></label>
                                <input
                                    type="password"
                                    id="new_password"
                                    wire:model="new_password"
                                    class="mk-input @error('new_password') is-invalid @enderror"
                                    placeholder="Minimal 8 karakter"
                                >
                                @error('new_password')
                                    <span class="mk-error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mk-form-group">
                                <label for="new_password_confirmation">Konfirmasi Password Baru <span class="required">*</span></label>
                                <input
                                    type="password"
                                    id="new_password_confirmation"
                                    wire:model="new_password_confirmation"
                                    class="mk-input"
                                    placeholder="Ketik ulang password baru"
                                >
                            </div>

                            <div class="mk-form-actions">
                                <button type="submit" class="mk-btn mk-btn-emerald" wire:loading.attr="disabled">
                                    <span wire:loading.remove><i class="fas fa-lock"></i> Update Password</span>
                                    <span wire:loading><i class="fas fa-circle-notch fa-spin"></i> Memproses...</span>
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="mk-empty-state">
                            <div class="mk-empty-icon">
                                <i class="fas fa-user-lock"></i>
                            </div>
                            <p class="title">Keamanan Kredensial Terjaga</p>
                            <p class="desc">Perbarui kata sandi secara berkala demi keamanan data akun medis Anda.</p>
                        </div>
                    @endif
                </div>

            </main>
        </div>

    </div>
</div>
