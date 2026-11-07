<div x-data="{
        scrolled: false,
        mobileOpen: false,
        chatOpen: false,
        userText: '',
        chatMessages: [
            {
                sender: 'bot',
                text: 'Halo! 👋 Saya <strong>SehatBot</strong>, asisten virtual Klinik MutiaraKesehatan.<br><br>Saya siap membantu Anda mengenai jadwal dokter, biaya, atau pendaftaran.',
                time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
            }
        ],
        sendMessage(textInput = null) {
            let text = textInput || this.userText;
            if (!text || text.trim() === '') return;

            let timeNow = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            this.chatMessages.push({
                sender: 'user',
                text: text,
                time: timeNow
            });

            if (!textInput) this.userText = '';

            this.$nextTick(() => {
                let chatArea = document.getElementById('chatMessagesArea');
                if (chatArea) chatArea.scrollTop = chatArea.scrollHeight;
            });

            setTimeout(() => {
                let reply = this.getBotReply(text.toLowerCase());
                this.chatMessages.push({
                    sender: 'bot',
                    text: reply,
                    time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
                });
                this.$nextTick(() => {
                    let chatArea = document.getElementById('chatMessagesArea');
                    if (chatArea) chatArea.scrollTop = chatArea.scrollHeight;
                });
            }, 600);
        },
        getBotReply(input) {
            if (input.includes('jam') || input.includes('buka') || input.includes('operasional')) {
                return '🕐 <strong>Jam Operasional Klinik:</strong><br>• Senin - Sabtu: 08:00 - 21:00 WIB<br>• Minggu: 09:00 - 14:00 WIB<br>🚑 <strong>IGD:</strong> 24 Jam';
            } else if (input.includes('jadwal') || input.includes('dokter')) {
                return '👨‍⚕️ <strong>Jadwal Dokter Spesialis Hari Ini:</strong><br>• <strong>dr. Ahmad Fauzi, Sp.PD</strong> (08:00 - 14:00)<br>• <strong>dr. Siti Nurhaliza, Sp.A</strong> (09:00 - 15:00)<br>• <strong>drg. Budi Santoso, Sp.Ort</strong> (10:00 - 17:00)';
            } else if (input.includes('biaya') || input.includes('tarif') || input.includes('harga')) {
                return '💰 <strong>Estimasi Biaya Konsultasi:</strong><br>• Dokter Umum: Rp 100.000 - Rp 150.000<br>• Dokter Spesialis: Rp 200.000 - Rp 350.000<br>✅ Menerima BPJS & Asuransi Swasta.';
            }
            return 'Terima kasih atas pertanyaan Anda. Untuk pendaftaran langsung silakan isi form booking di sebelah kiri atau hubungi (021) 123-4567.';
        }
    }"
    x-init="
        window.addEventListener('scroll', () => {
            scrolled = window.pageYOffset > 50;
        });
    ">

    <!-- ================= HEADER / NAVBAR ================= -->
    <header class="header" id="header" data-aos="fade-down" data-aos-duration="600">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="container">
                <div class="top-bar-content">
                    <div class="top-bar-left">
                        <span><i class="fas fa-clock"></i> Senin - Sabtu: 08:00 - 21:00 WIB</span>
                        <span class="separator">|</span>
                        <span><i class="fas fa-map-marker-alt"></i> Jl. Kesehatan No. 123, Jakarta Selatan</span>
                    </div>
                    <div class="top-bar-right">
                        <a href="tel:+622112345678" class="emergency-link">
                            <i class="fas fa-phone-alt"></i> Darurat: (021) 123-4567
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav class="navbar" id="navbar">
            <div class="container">
                <div class="nav-wrapper">
                    <!-- Logo -->
                    <a href="#beranda" class="logo">
                        <div class="logo-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div class="logo-text">
                            <span class="logo-name">MutiaraKesehatan</span>
                            <span class="logo-tagline">Klinik Kesehatan Modern</span>
                        </div>
                    </a>

                    <!-- Desktop Navigation Menu -->
                    <ul class="nav-menu desktop-only" id="navMenu">
                        <li><a href="#beranda" class="nav-link active">Beranda</a></li>
                        <li><a href="#layanan" class="nav-link">Layanan</a></li>
                        <li><a href="#dokter" class="nav-link">Dokter</a></li>
                        <li><a href="#janji" class="nav-link">Buat Janji</a></li>
                    </ul>

                    <!-- CTA Button & Mobile Toggle -->
                    <div class="nav-actions">
                        @auth
                            <div class="user-dropdown-container desktop-only" id="userDropdownContainer">
                                <button type="button" class="user-dropdown-btn" id="userDropdownBtn">
                                    <div class="user-avatar-sm">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                        <span class="online-indicator"></span>
                                    </div>
                                    <span class="user-name-text">{{ auth()->user()->name }}</span>
                                    <i class="fas fa-chevron-down chevron-icon"></i>
                                </button>

                                <div class="user-dropdown-menu" id="userDropdownMenu">
                                    <div class="dropdown-user-header">
                                        <div class="user-avatar-lg">
                                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="user-header-info">
                                            <p class="user-header-name">{{ auth()->user()->name }}</p>
                                            <p class="user-header-email">{{ auth()->user()->email ?? 'Pasien Terdaftar' }}</p>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <ul class="dropdown-links">
                                        <li>
                                            <a href="{{ route('settings') }}" class="dropdown-item">
                                                <div class="item-icon teal"><i class="fas fa-cog"></i></div>
                                                <div class="item-text">
                                                    <span>Pengaturan Akun</span>
                                                    <small>Profil & keamanan kata sandi</small>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="dropdown-divider"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item logout-btn">
                                            <div class="item-icon rose"><i class="fas fa-sign-out-alt"></i></div>
                                            <div class="item-text"><span>Keluar Sistem</span></div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="/login" class="btn btn-outline btn-sm login-btn-custom desktop-only">
                                <i class="fas fa-sign-in-alt"></i> <span>Masuk</span>
                            </a>
                        @endauth

                        <a href="tel:+622112345678" class="btn-emergency desktop-only">
                            <i class="fas fa-phone-alt"></i> <span>Darurat</span>
                        </a>

                        <button class="mobile-toggle" id="mobileToggle" aria-label="Buka Menu Navigation">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Drawer -->
        <div class="mobile-overlay" id="mobileOverlay"></div>
        <aside class="mobile-drawer" id="mobileDrawer">
            <div class="drawer-header">
                <div class="drawer-logo">
                    <div class="logo-icon sm"><i class="fas fa-heartbeat"></i></div>
                    <span class="drawer-title">MutiaraKesehatan</span>
                </div>
                <button class="drawer-close-btn" id="drawerCloseBtn" aria-label="Tutup Menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @auth
                <div class="mobile-user-card">
                    <div class="mobile-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        <span class="online-indicator"></span>
                    </div>
                    <div class="mobile-user-info">
                        <p class="mobile-user-name">{{ auth()->user()->name }}</p>
                        <span class="mobile-user-badge"><i class="fas fa-shield-alt"></i> Pasien Terverifikasi</span>
                    </div>
                </div>
            @else
                <div class="mobile-guest-card">
                    <p class="guest-title">Selamat Datang!</p>
                    <p class="guest-desc">Masuk untuk mengakses antrean & rekam medis Anda.</p>
                    <a href="/login" class="mobile-btn-login">
                        <i class="fas fa-sign-in-alt"></i> Masuk / Daftar Akun
                    </a>
                </div>
            @endauth
            <div class="drawer-content">
                <p class="drawer-section-label">Navigasi Utama</p>
                <ul class="mobile-nav-links">
                    <li><a href="#beranda" class="mobile-nav-item active"><i class="fas fa-home"></i> <span>Beranda</span></a></li>
                    <li><a href="#layanan" class="mobile-nav-item"><i class="fas fa-stethoscope"></i> <span>Layanan Medis</span></a></li>
                    <li><a href="#dokter" class="mobile-nav-item"><i class="fas fa-user-md"></i> <span>Jadwal Dokter</span></a></li>
                    <li><a href="#janji" class="mobile-nav-item"><i class="fas fa-calendar-check"></i> <span>Buat Janji Temu</span></a></li>
                    @auth
                        <p class="drawer-section-label">Akun Saya</p>
                        <li><a href="{{ route('settings') }}" class="mobile-nav-item"><i class="fas fa-cog"></i> <span>Pengaturan Akun</span></a></li>
                    @endauth
                </ul>
            </div>
            <div class="drawer-footer">
                <a href="tel:+622112345678" class="mobile-emergency-btn">
                    <i class="fas fa-phone-alt"></i> Layanan Darurat 24 Jam
                </a>
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="mobile-logout-form">
                        @csrf
                        <button type="submit" class="mobile-logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Keluar Akun
                        </button>
                    </form>
                @endauth
            </div>
        </aside>
    </header>

    <!-- ================= HERO SECTION ================= -->
    <section class="hero" id="beranda">
        <div class="hero-bg-pattern"></div>
        <div class="container">
            <div class="hero-wrapper">
                <div class="hero-content">
                    <div class="hero-badge" data-aos="fade-right" data-aos-duration="600">
                        <i class="fas fa-shield-alt"></i>
                        <span>Terakreditasi Paripurna KARS 2024</span>
                    </div>
                    <h1 class="hero-title" data-aos="fade-right" data-aos-duration="700" data-aos-delay="100">
                        Kesehatan Anda,<br>
                        <span class="highlight">Prioritas Kami</span>
                    </h1>
                    <p class="hero-description" data-aos="fade-right" data-aos-duration="800" data-aos-delay="200">
                        Klinik MutiaraKesehatan hadir memberikan layanan kesehatan berkualitas tinggi
                        dengan teknologi medis terkini dan tim dokter spesialis berpengalaman.
                    </p>
                    <div class="hero-actions" data-aos="fade-right" data-aos-duration="800" data-aos-delay="300">
                        <a href="#janji" class="btn btn-primary btn-lg">
                            <i class="fas fa-calendar-check"></i> Buat Janji Konsultasi
                        </a>
                        <a href="#layanan" class="btn btn-outline btn-lg">
                            <i class="fas fa-stethoscope"></i> Lihat Layanan
                        </a>
                    </div>
                    <div class="hero-trust" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                        <div class="trust-item"><i class="fas fa-check-circle"></i> <span>Dokter Bersertifikat</span></div>
                        <div class="trust-item"><i class="fas fa-check-circle"></i> <span>Teknologi Modern</span></div>
                        <div class="trust-item"><i class="fas fa-check-circle"></i> <span>BPJS & Asuransi</span></div>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-image-wrapper">
                        <div class="hero-image-placeholder" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="200">
                            <i class="fas fa-user-md"></i>
                            <span>Tim Medis Profesional</span>
                        </div>
                        <div class="floating-card card-1" data-aos="fade-left" data-aos-duration="800" data-aos-delay="400">
                            <i class="fas fa-calendar-check"></i>
                            <div>
                                <strong>500+</strong>
                                <span>Pasien/Bulan</span>
                            </div>
                        </div>
                        <div class="floating-card card-2" data-aos="fade-right" data-aos-duration="800" data-aos-delay="500">
                            <i class="fas fa-star"></i>
                            <div>
                                <strong>4.9/5</strong>
                                <span>Rating Pasien</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stats-bar">
            <div class="container" data-aos="fade-up" data-aos-duration="800">
                <div class="stats-grid">
                    <div class="stat-item" data-aos="zoom-in" data-aos-delay="100">
                        <div class="stat-number" data-target="15000">0</div>
                        <div class="stat-label">Pasien Terlayani</div>
                    </div>
                    <div class="stat-item" data-aos="zoom-in" data-aos-delay="200">
                        <div class="stat-number" data-target="25">0</div>
                        <div class="stat-label">Dokter Spesialis</div>
                    </div>
                    <div class="stat-item" data-aos="zoom-in" data-aos-delay="300">
                        <div class="stat-number" data-target="12">0</div>
                        <div class="stat-label">Layanan Medis</div>
                    </div>
                    <div class="stat-item" data-aos="zoom-in" data-aos-delay="400">
                        <div class="stat-number" data-target="10">0</div>
                        <div class="stat-label">Tahun Pengalaman</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= SERVICES SECTION ================= -->
    <section class="services" id="layanan">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="700">
                <span class="section-subtitle">Layanan Unggulan Kami</span>
                <h2 class="section-title">Layanan Medis <span class="highlight">Komprehensif</span></h2>
                <p class="section-description">
                    Kami menyediakan berbagai layanan kesehatan berkualitas tinggi untuk memenuhi kebutuhan medis Anda dan keluarga.
                </p>
            </div>

            <div class="services-grid">
                <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-icon"><i class="fas fa-stethoscope"></i></div>
                    <h3 class="service-title">Poliklinik Umum</h3>
                    <p class="service-description">Pemeriksaan kesehatan umum dan penanganan penyakit oleh dokter umum berpengalaman.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Pemeriksaan Fisik Lengkap</li>
                        <li><i class="fas fa-check"></i> Resep & Surat Keterangan</li>
                    </ul>
                    <a href="#janji" class="service-link">Buat Janji <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-icon"><i class="fas fa-tooth"></i></div>
                    <h3 class="service-title">Klinik Gigi</h3>
                    <p class="service-description">Perawatan gigi dan mulut komprehensif mulai dari scaling hingga prosedur estetika.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Scaling & Whitening</li>
                        <li><i class="fas fa-check"></i> Orthodonti (Behel)</li>
                    </ul>
                    <a href="#janji" class="service-link">Buat Janji <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-icon"><i class="fas fa-baby"></i></div>
                    <h3 class="service-title">Klinik Anak</h3>
                    <p class="service-description">Layanan imunisasi, tumbuh kembang, dan penanganan penyakit oleh spesialis anak.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Imunisasi Lengkap</li>
                        <li><i class="fas fa-check"></i> Monitoring Tumbuh Kembang</li>
                    </ul>
                    <a href="#janji" class="service-link">Buat Janji <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-icon"><i class="fas fa-flask"></i></div>
                    <h3 class="service-title">Laboratorium</h3>
                    <p class="service-description">Pemeriksaan laboratorium lengkap dengan peralatan modern dan hasil akurat.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Darah Lengkap & Kimia</li>
                        <li><i class="fas fa-check"></i> Hasil Cepat (1-2 Jam)</li>
                    </ul>
                    <a href="#janji" class="service-link">Buat Janji <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="service-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-icon"><i class="fas fa-heart"></i></div>
                    <h3 class="service-title">Klinik Jantung</h3>
                    <p class="service-description">Pemeriksaan kardiovaskular oleh dokter spesialis jantung dengan EKG & Echocardiography.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> EKG & Treadmill Test</li>
                        <li><i class="fas fa-check"></i> Echocardiography</li>
                    </ul>
                    <a href="#janji" class="service-link">Buat Janji <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="service-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-icon"><i class="fas fa-x-ray"></i></div>
                    <h3 class="service-title">Radiologi</h3>
                    <p class="service-description">Layanan pencitraan medis meliputi Rontgen Digital, USG 4D, dan CT Scan.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Rontgen Digital</li>
                        <li><i class="fas fa-check"></i> USG 4D</li>
                    </ul>
                    <a href="#janji" class="service-link">Buat Janji <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= DOCTORS SECTION (DINAMIS DARI DATABASE) ================= -->
    <section class="doctors" id="dokter">
        <div class="container">
            <div class="section-header" data-aos="fade-up" data-aos-duration="700">
                <span class="section-subtitle">Tim Medis Kami</span>
                <h2 class="section-title">Dokter <span class="highlight">Spesialis</span> Berpengalaman</h2>
                <p class="section-description">
                    Didukung oleh tim dokter bersertifikat dengan pengalaman di bidangnya masing-masing.
                </p>
            </div>

            <div class="doctors-grid">
                @forelse($doctors ?? [] as $index => $doctor)
                    <div class="doctor-card" data-aos="fade-up" data-aos-delay="{{ ($index % 4 + 1) * 100 }}" data-aos-duration="750">
                        <div class="doctor-image">
                            @if(isset($doctor->photo) && $doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name }}" class="doctor-img-fluid">
                            @else
                                <div class="doctor-photo-placeholder">
                                    <i class="fas fa-user-md"></i>
                                </div>
                            @endif
                            <div class="doctor-status">
                                <span class="status-dot {{ ($doctor->is_available ?? true) ? 'available' : 'unavailable' }}"></span>
                                <span>{{ ($doctor->is_available ?? true) ? 'Tersedia Hari Ini' : ($doctor->next_available ?? 'Jadwal Mendatang') }}</span>
                            </div>
                        </div>
                        <div class="doctor-info">
                            <h3 class="doctor-name">{{ $doctor->name }}</h3>
                            <p class="doctor-specialty">{{ $doctor->specialty ?? $doctor->specialization ?? 'Dokter Spesialis' }}</p>
                            <div class="doctor-details">
                                <div class="detail-item">
                                    <i class="fas fa-graduation-cap"></i>
                                    <span>{{ $doctor->almamater ?? $doctor->education ?? 'Alumni FKM / FK Terbaik' }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-briefcase-medical"></i>
                                    <span>{{ $doctor->experience ?? '5+' }} Tahun Pengalaman</span>
                                </div>
                            </div>
                            <div class="doctor-schedule">
                                <span class="schedule-label">Jadwal Praktik:</span>
                                <div class="schedule-days">
                                    @if(isset($doctor->schedules) && is_array($doctor->schedules))
                                        @foreach($doctor->schedules as $day)
                                            <span class="day-badge">{{ $day }}</span>
                                        @endforeach
                                    @else
                                        <span class="day-badge">Sen</span>
                                        <span class="day-badge">Rab</span>
                                        <span class="day-badge">Jum</span>
                                    @endif
                                </div>
                                <span class="schedule-time">{{ $doctor->practice_hours ?? '08:00 - 16:00 WIB' }}</span>
                            </div>
                            <a href="#janji" onclick="selectDoctorForBooking('{{ $doctor->id ?? $doctor->name }}')" class="btn btn-primary btn-sm">
                                <i class="fas fa-calendar-check"></i> Buat Janji
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="no-doctors-found" data-aos="fade-up" style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #f8fafc; border-radius: 16px;">
                        <i class="fas fa-user-md-slash" style="font-size: 3rem; color: #94a3b8; margin-bottom: 12px;"></i>
                        <h4 style="font-weight: 700; color: #1e293b;">Belum ada dokter yang terdaftar</h4>
                        <p style="color: #64748b; font-size: 0.9rem;">Jadwal dokter sedang diperbarui oleh pihak administrator klinik.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ================= APPOINTMENT FORM SECTION ================= -->
    <section class="appointment" id="janji">
        <div class="container">
            <div class="appointment-wrapper">
                <div class="appointment-info" data-aos="fade-right" data-aos-duration="800">
                    <span class="section-subtitle light">Buat Janji Temu</span>
                    <h2 class="section-title light">Reservasi Jadwal <span class="highlight">Konsultasi</span> Anda</h2>
                    <p class="appointment-description">
                        Isi formulir di samping untuk membuat janji temu. Anda akan otomatis dialihkan ke wizard pendaftaran untuk verifikasi dan konfirmasi nomor antrean.
                    </p>
                    <div class="appointment-benefits">
                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="fas fa-clock"></i></div>
                            <div>
                                <h4>Tanpa Antri Lama</h4>
                                <p>Datang sesuai jadwal, langsung dilayani</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="fas fa-bell"></i></div>
                            <div>
                                <h4>Pengingat Otomatis</h4>
                                <p>Notifikasi H-1 via WhatsApp</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="appointment-form-wrapper" data-aos="fade-left" data-aos-duration="800">
                    <form class="appointment-form" id="appointmentForm" action="{{ route('booking-wizard') }}" method="GET" novalidate>
                        <h3 class="form-title">Formulir Pendaftaran</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="patientName" class="form-label">Nama Lengkap <span class="required">*</span></label>
                                <input type="text" id="patientName" name="name" class="form-input" placeholder="Masukkan nama lengkap" required>
                                <span class="form-error" id="nameError"></span>
                            </div>
                            <div class="form-group">
                                <label for="patientEmail" class="form-label">Email <span class="required">*</span></label>
                                <input type="email" id="patientEmail" name="email" class="form-input" placeholder="email@contoh.com" required>
                                <span class="form-error" id="emailError"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="patientPhone" class="form-label">No. Telepon/WA <span class="required">*</span></label>
                                <input type="tel" id="patientPhone" name="phone" class="form-input" placeholder="08xxxxxxxxxx" required>
                                <span class="form-error" id="phoneError"></span>
                            </div>
                            <div class="form-group">
                                <label for="appointmentDate" class="form-label">Tanggal Kunjungan <span class="required">*</span></label>
                                <input type="date" id="appointmentDate" name="date" class="form-input" required>
                                <span class="form-error" id="dateError"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="serviceSelect" class="form-label">Pilih Poli/Layanan <span class="required">*</span></label>
                                <select id="serviceSelect" name="service" class="form-input form-select" required>
                                    <option value="">-- Pilih Layanan --</option>
                                    <option value="umum">Poliklinik Umum</option>
                                    <option value="gigi">Klinik Gigi</option>
                                    <option value="anak">Klinik Anak</option>
                                    <option value="jantung">Klinik Jantung</option>
                                    <option value="lab">Laboratorium</option>
                                    <option value="radiologi">Radiologi</option>
                                </select>
                                <span class="form-error" id="serviceError"></span>
                            </div>
                            <div class="form-group">
                                <label for="doctorSelect" class="form-label">Pilih Dokter</label>
                                <select id="doctorSelect" name="doctor_id" class="form-input form-select">
                                    <option value="">-- Pilih Dokter --</option>
                                    @foreach($doctors ?? [] as $doc)
                                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="patientNotes" class="form-label">Keluhan / Catatan Tambahan</label>
                            <textarea id="patientNotes" name="notes" class="form-input form-textarea" rows="3" placeholder="Jelaskan keluhan atau catatan khusus..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-full" id="submitBtn">
                            <i class="fas fa-paper-plane"></i>
                            <span>Lanjutkan ke Booking Wizard</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="footer" id="kontak" data-aos="fade-up" data-aos-duration="800">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <div class="logo-icon"><i class="fas fa-heartbeat"></i></div>
                        <div class="logo-text">
                            <span class="logo-name">MutiaraKesehatan</span>
                            <span class="logo-tagline">Klinik Kesehatan Modern</span>
                        </div>
                    </div>
                    <p class="footer-about">
                        Klinik MutiaraKesehatan berkomitmen memberikan layanan kesehatan terbaik dengan pendekatan personal.
                    </p>
                </div>

                <div class="footer-col">
                    <h4 class="footer-heading">Tautan Cepat</h4>
                    <ul class="footer-links">
                        <li><a href="#beranda"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                        <li><a href="#layanan"><i class="fas fa-chevron-right"></i> Layanan Kami</a></li>
                        <li><a href="#dokter"><i class="fas fa-chevron-right"></i> Tim Dokter</a></li>
                        <li><a href="#janji"><i class="fas fa-chevron-right"></i> Buat Janji</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-heading">Jam Operasional</h4>
                    <ul class="footer-hours">
                        <li><span>Senin - Jumat</span> <strong>08:00 - 21:00</strong></li>
                        <li><span>Sabtu</span> <strong>08:00 - 17:00</strong></li>
                        <li class="hours-emergency"><i class="fas fa-ambulance"></i> <span>IGD 24 Jam</span></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-heading">Hubungi Kami</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> <span>Jl. Kesehatan No. 123, Jakarta</span></li>
                        <li><i class="fas fa-phone-alt"></i> <a href="tel:+622112345678">(021) 123-4567</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2026 Klinik MutiaraKesehatan. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- ================= CHATBOT WIDGET ================= -->
    <div class="chatbot-widget">
        <button type="button" class="chatbot-toggle" @click="chatOpen = !chatOpen">
            <span class="chatbot-toggle-icon"><i class="fas fa-comments"></i></span>
            <span class="chatbot-badge" id="chatbotBadge">1</span>
        </button>

        <div class="chatbot-window" :class="{ 'open': chatOpen }">
            <div class="chatbot-header">
                <div class="chatbot-header-info">
                    <div class="chatbot-avatar"><i class="fas fa-robot"></i></div>
                    <div class="chatbot-header-text">
                        <h4>SehatBot Assistant</h4>
                        <span class="chatbot-status">Online</span>
                    </div>
                </div>
                <button type="button" class="chatbot-action-btn" @click="chatOpen = false"><i class="fas fa-times"></i></button>
            </div>

            <div class="chatbot-messages" id="chatMessagesArea">
                <template x-for="(msg, index) in chatMessages" :key="index">
                    <div class="message" :class="msg.sender">
                        <div class="message-bubble" x-html="msg.text"></div>
                    </div>
                </template>
            </div>

            <div class="chatbot-quick-replies">
                <button type="button" class="quick-reply-btn" @click="sendMessage('jam operasional')"><i class="fas fa-clock"></i> Jam Buka</button>
                <button type="button" class="quick-reply-btn" @click="sendMessage('jadwal dokter')"><i class="fas fa-user-md"></i> Jadwal Dokter</button>
                <button type="button" class="quick-reply-btn" @click="sendMessage('biaya')"><i class="fas fa-money-bill-wave"></i> Biaya</button>
            </div>

            <div class="chatbot-input-area">
                <div class="chatbot-input-wrapper">
                    <input type="text" x-model="userText" @keydown.enter.prevent="sendMessage()" class="chatbot-input" placeholder="Ketik pertanyaan Anda...">
                    <button type="button" @click="sendMessage()" class="chatbot-send-btn"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================= JAVASCRIPT LOGIC ================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inisialisasi AOS (Animate On Scroll)
        if (typeof AOS !== 'undefined') {
            AOS.init({
                once: true,
                duration: 750,
                easing: 'ease-out-cubic',
                offset: 100
            });
        }

        // 2. Logic Mobile Drawer Toggle (Vanilla JS)
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileDrawer = document.getElementById('mobileDrawer');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const drawerCloseBtn = document.getElementById('drawerCloseBtn');

        function openMobileMenu() {
            if (mobileDrawer && mobileOverlay && mobileToggle) {
                mobileDrawer.classList.add('active');
                mobileOverlay.classList.add('active');
                mobileToggle.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeMobileMenu() {
            if (mobileDrawer && mobileOverlay && mobileToggle) {
                mobileDrawer.classList.remove('active');
                mobileOverlay.classList.remove('active');
                mobileToggle.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        if (mobileToggle) mobileToggle.addEventListener('click', openMobileMenu);
        if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);
        if (drawerCloseBtn) drawerCloseBtn.addEventListener('click', closeMobileMenu);

        // 3. User Dropdown Toggle (Desktop)
        const dropdownContainer = document.getElementById('userDropdownContainer');
        const dropdownBtn = document.getElementById('userDropdownBtn');
        if (dropdownContainer && dropdownBtn) {
            dropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownContainer.classList.toggle('active');
            });
            document.addEventListener('click', function(e) {
                if (!dropdownContainer.contains(e.target)) {
                    dropdownContainer.classList.remove('active');
                }
            });
        }

        //4. Submit Form -> Redireksi ke Booking Wizard
        const form = document.getElementById('appointmentForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const name = document.getElementById('patientName').value;
                const email = document.getElementById('patientEmail').value;
                const phone = document.getElementById('patientPhone').value;
                const date = document.getElementById('appointmentDate').value;
                const service = document.getElementById('serviceSelect').value;

                if (!name || !email || !phone || !date || !service) {
                    alert('Mohon lengkapi semua kolom bertanda bintang (*) sebelum melanjutkan.');
                    return;
                }

                const formData = new FormData(form);
                const params = new URLSearchParams(formData).toString();

                // 💡 Menggunakan helper route() Laravel langsung agar URL selalu akurat
                const targetUrl = "{{ route('booking-wizard') }}";

                window.location.href = targetUrl + "?" + params;
            });
        }
    });

    function selectDoctorForBooking(doctorId) {
        const doctorSelect = document.getElementById('doctorSelect');
        if (doctorSelect) {
            doctorSelect.value = doctorId;
        }
    }
</script>
