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

            // 1. Tambah Pesan User
            let timeNow = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            this.chatMessages.push({
                sender: 'user',
                text: text,
                time: timeNow
            });

            if (!textInput) this.userText = '';

            // Auto Scroll ke Bawah
            this.$nextTick(() => {
                let chatArea = document.getElementById('chatMessagesArea');
                if (chatArea) chatArea.scrollTop = chatArea.scrollHeight;
            });

            // 2. Logic Auto-Reply Pure JS
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
    <header class="header" id="header">
        <!-- Top Bar - Info Kontak & Jam Operasional -->
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
                    <ul class="nav-menu" id="navMenu">
                        <li><a href="#beranda" class="nav-link active">Beranda</a></li>
                        <li><a href="#layanan" class="nav-link">Layanan</a></li>
                        <li><a href="#dokter" class="nav-link">Dokter</a></li>
                        <li><a href="#janji" class="nav-link">Buat Janji</a></li>
                    </ul>

                    <!-- CTA Button & Mobile Toggle -->
                    <div class="nav-actions">
                        <a href="/login" class="btn btn-outline btn-sm" style="border-radius: var(--radius-full); padding: 0.5rem 1.2rem;">
                            <i class="fas fa-sign-in-alt"></i> <span>Masuk</span>
                        </a>

                        <a href="tel:+622112345678" class="btn-emergency">
                            <i class="fas fa-phone-alt"></i>
                            <span>Darurat</span>
                        </a>

                        <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle navigation menu">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- ================= HERO SECTION ================= -->
    <section class="hero" id="beranda">
        <div class="hero-bg-pattern"></div>
        <div class="container">
            <div class="hero-wrapper">
                <!-- Hero Content -->
                <div class="hero-content">
                    <div class="hero-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Terakreditasi Paripurna KARS 2024</span>
                    </div>
                    <h1 class="hero-title">
                        Kesehatan Anda,<br>
                        <span class="highlight">Prioritas Kami</span>
                    </h1>
                    <p class="hero-description">
                        Klinik SehatSejahtera hadir memberikan layanan kesehatan berkualitas tinggi
                        dengan teknologi medis terkini dan tim dokter spesialis berpengalaman.
                        Kami berkomitmen untuk kesehatan Anda dan keluarga.
                    </p>
                    <div class="hero-actions">
                        <a href="#janji" class="btn btn-primary btn-lg">
                            <i class="fas fa-calendar-check"></i>
                            Buat Janji Konsultasi
                        </a>
                        <a href="#layanan" class="btn btn-outline btn-lg">
                            <i class="fas fa-stethoscope"></i>
                            Lihat Layanan
                        </a>
                    </div>
                    <!-- Trust Indicators -->
                    <div class="hero-trust">
                        <div class="trust-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Dokter Bersertifikat</span>
                        </div>
                        <div class="trust-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Teknologi Modern</span>
                        </div>
                        <div class="trust-item">
                            <i class="fas fa-check-circle"></i>
                            <span>BPJS & Asuransi</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Visual -->
                <div class="hero-visual">
                    <div class="hero-image-wrapper">
                        <div class="hero-image-placeholder">
                            <i class="fas fa-user-md"></i>
                            <span>Tim Medis Profesional</span>
                        </div>
                        <!-- Floating Cards -->
                        <div class="floating-card card-1">
                            <i class="fas fa-calendar-check"></i>
                            <div>
                                <strong>500+</strong>
                                <span>Pasien/Bulan</span>
                            </div>
                        </div>
                        <div class="floating-card card-2">
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

        <!-- Statistics Bar -->
        <div class="stats-bar">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number" data-target="15000">0</div>
                        <div class="stat-label">Pasien Terlayani</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="25">0</div>
                        <div class="stat-label">Dokter Spesialis</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="12">0</div>
                        <div class="stat-label">Layanan Medis</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="10">0</div>
                        <div class="stat-label">Tahun Pengalaman</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         SERVICES SECTION
         ============================================ -->
    <section class="services" id="layanan">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header">
                <span class="section-subtitle">Layanan Unggulan Kami</span>
                <h2 class="section-title">Layanan Medis <span class="highlight">Komprehensif</span></h2>
                <p class="section-description">
                    Kami menyediakan berbagai layanan kesehatan berkualitas tinggi untuk memenuhi
                    kebutuhan medis Anda dan keluarga dengan standar internasional.
                </p>
            </div>

            <!-- Services Grid -->
            <div class="services-grid">
                <!-- Service Card 1 -->
                <div class="service-card" data-aos="fade-up">
                    <div class="service-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <h3 class="service-title">Poliklinik Umum</h3>
                    <p class="service-description">
                        Pemeriksaan kesehatan umum, konsultasi medis, dan penanganan penyakit
                        ringan hingga sedang oleh dokter umum berpengalaman.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Pemeriksaan Fisik Lengkap</li>
                        <li><i class="fas fa-check"></i> Resep & Surat Keterangan</li>
                        <li><i class="fas fa-check"></i> Konsultasi Lanjutan</li>
                    </ul>
                    <a href="#janji" class="service-link">
                        Buat Janji <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Service Card 2 -->
                <div class="service-card" data-aos="fade-up">
                    <div class="service-icon">
                        <i class="fas fa-tooth"></i>
                    </div>
                    <h3 class="service-title">Klinik Gigi</h3>
                    <p class="service-description">
                        Perawatan gigi dan mulut komprehensif mulai dari pembersihan,
                        penambalan, hingga prosedur estetika gigi.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Scaling & Whitening</li>
                        <li><i class="fas fa-check"></i> Tambal & Cabut Gigi</li>
                        <li><i class="fas fa-check"></i> Orthodonti (Behel)</li>
                    </ul>
                    <a href="#janji" class="service-link">
                        Buat Janji <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Service Card 3 -->
                <div class="service-card" data-aos="fade-up">
                    <div class="service-icon">
                        <i class="fas fa-baby"></i>
                    </div>
                    <h3 class="service-title">Klinik Anak</h3>
                    <p class="service-description">
                        Layanan kesehatan khusus anak meliputi imunisasi, tumbuh kembang,
                        dan penanganan penyakit anak oleh dokter spesialis anak.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Imunisasi Lengkap</li>
                        <li><i class="fas fa-check"></i> Monitoring Tumbuh Kembang</li>
                        <li><i class="fas fa-check"></i> Konsultasi Nutrisi Anak</li>
                    </ul>
                    <a href="#janji" class="service-link">
                        Buat Janji <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Service Card 4 -->
                <div class="service-card" data-aos="fade-up">
                    <div class="service-icon">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h3 class="service-title">Laboratorium</h3>
                    <p class="service-description">
                        Pemeriksaan laboratorium lengkap dengan peralatan modern dan
                        hasil yang akurat untuk mendukung diagnosis medis.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Darah Lengkap & Kimia</li>
                        <li><i class="fas fa-check"></i> Urine & Feses</li>
                        <li><i class="fas fa-check"></i> Hasil Cepat (1-2 Jam)</li>
                    </ul>
                    <a href="#janji" class="service-link">
                        Buat Janji <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Service Card 5 -->
                <div class="service-card" data-aos="fade-up">
                    <div class="service-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="service-title">Klinik Jantung</h3>
                    <p class="service-description">
                        Pemeriksaan dan penanganan penyakit kardiovaskular oleh dokter
                        spesialis jantung dengan teknologi EKG dan Echocardiography.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> EKG & Treadmill Test</li>
                        <li><i class="fas fa-check"></i> Echocardiography</li>
                        <li><i class="fas fa-check"></i> Konsultasi Jantung</li>
                    </ul>
                    <a href="#janji" class="service-link">
                        Buat Janji <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Service Card 6 -->
                <div class="service-card" data-aos="fade-up">
                    <div class="service-icon">
                        <i class="fas fa-x-ray"></i>
                    </div>
                    <h3 class="service-title">Radiologi</h3>
                    <p class="service-description">
                        Layanan pencitraan medis meliputi Rontgen, USG, dan CT Scan
                        untuk diagnosis yang lebih akurat dan tepat.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Rontgen Digital</li>
                        <li><i class="fas fa-check"></i> USG 4D</li>
                        <li><i class="fas fa-check"></i> CT Scan 128 Slice</li>
                    </ul>
                    <a href="#janji" class="service-link">
                        Buat Janji <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         DOCTORS SECTION
         ============================================ -->
    <section class="doctors" id="dokter">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header">
                <span class="section-subtitle">Tim Medis Kami</span>
                <h2 class="section-title">Dokter <span class="highlight">Spesialis</span> Berpengalaman</h2>
                <p class="section-description">
                    Didukung oleh tim dokter spesialis bersertifikat dengan pengalaman
                    bertahun-tahun di bidangnya masing-masing.
                </p>
            </div>

            <!-- Doctors Grid -->
            <div class="doctors-grid">
                <!-- Doctor Card 1 -->
                <div class="doctor-card">
                    <div class="doctor-image">
                        <div class="doctor-photo-placeholder">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="doctor-status">
                            <span class="status-dot available"></span>
                            <span>Tersedia Hari Ini</span>
                        </div>
                    </div>
                    <div class="doctor-info">
                        <h3 class="doctor-name">dr. Ahmad Fauzi, Sp.PD</h3>
                        <p class="doctor-specialty">Spesialis Penyakit Dalam</p>
                        <div class="doctor-details">
                            <div class="detail-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>UI & RS Cipto Mangunkusumo</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-briefcase-medical"></i>
                                <span>15 Tahun Pengalaman</span>
                            </div>
                        </div>
                        <div class="doctor-schedule">
                            <span class="schedule-label">Jadwal Praktik:</span>
                            <div class="schedule-days">
                                <span class="day-badge">Sen</span>
                                <span class="day-badge">Rab</span>
                                <span class="day-badge">Jum</span>
                            </div>
                            <span class="schedule-time">08:00 - 14:00 WIB</span>
                        </div>
                        <a href="#janji" class="btn btn-primary btn-sm">
                            <i class="fas fa-calendar-check"></i> Buat Janji
                        </a>
                    </div>
                </div>

                <!-- Doctor Card 2 -->
                <div class="doctor-card">
                    <div class="doctor-image">
                        <div class="doctor-photo-placeholder">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="doctor-status">
                            <span class="status-dot available"></span>
                            <span>Tersedia Hari Ini</span>
                        </div>
                    </div>
                    <div class="doctor-info">
                        <h3 class="doctor-name">dr. Siti Nurhaliza, Sp.A</h3>
                        <p class="doctor-specialty">Spesialis Anak</p>
                        <div class="doctor-details">
                            <div class="detail-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>UGM & RS Anak Jakarta</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-briefcase-medical"></i>
                                <span>12 Tahun Pengalaman</span>
                            </div>
                        </div>
                        <div class="doctor-schedule">
                            <span class="schedule-label">Jadwal Praktik:</span>
                            <div class="schedule-days">
                                <span class="day-badge">Sel</span>
                                <span class="day-badge">Kam</span>
                                <span class="day-badge">Sab</span>
                            </div>
                            <span class="schedule-time">09:00 - 15:00 WIB</span>
                        </div>
                        <a href="#janji" class="btn btn-primary btn-sm">
                            <i class="fas fa-calendar-check"></i> Buat Janji
                        </a>
                    </div>
                </div>

                <!-- Doctor Card 3 -->
                <div class="doctor-card">
                    <div class="doctor-image">
                        <div class="doctor-photo-placeholder">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="doctor-status">
                            <span class="status-dot available"></span>
                            <span>Tersedia Hari Ini</span>
                        </div>
                    </div>
                    <div class="doctor-info">
                        <h3 class="doctor-name">drg. Budi Santoso, Sp.Ort</h3>
                        <p class="doctor-specialty">Spesialis Ortodonti Gigi</p>
                        <div class="doctor-details">
                            <div class="detail-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>Unpad & AADB Melbourne</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-briefcase-medical"></i>
                                <span>10 Tahun Pengalaman</span>
                            </div>
                        </div>
                        <div class="doctor-schedule">
                            <span class="schedule-label">Jadwal Praktik:</span>
                            <div class="schedule-days">
                                <span class="day-badge">Sen</span>
                                <span class="day-badge">Sel</span>
                                <span class="day-badge">Kam</span>
                                <span class="day-badge">Jum</span>
                            </div>
                            <span class="schedule-time">10:00 - 17:00 WIB</span>
                        </div>
                        <a href="#janji" class="btn btn-primary btn-sm">
                            <i class="fas fa-calendar-check"></i> Buat Janji
                        </a>
                    </div>
                </div>

                <!-- Doctor Card 4 -->
                <div class="doctor-card">
                    <div class="doctor-image">
                        <div class="doctor-photo-placeholder">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="doctor-status">
                            <span class="status-dot unavailable"></span>
                            <span>Senin Depan</span>
                        </div>
                    </div>
                    <div class="doctor-info">
                        <h3 class="doctor-name">dr. Rina Wati, Sp.JP</h3>
                        <p class="doctor-specialty">Spesialis Jantung & Pembuluh Darah</p>
                        <div class="doctor-details">
                            <div class="detail-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>Undip & National Heart Centre SG</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-briefcase-medical"></i>
                                <span>18 Tahun Pengalaman</span>
                            </div>
                        </div>
                        <div class="doctor-schedule">
                            <span class="schedule-label">Jadwal Praktik:</span>
                            <div class="schedule-days">
                                <span class="day-badge">Sen</span>
                                <span class="day-badge">Rab</span>
                                <span class="day-badge">Jum</span>
                            </div>
                            <span class="schedule-time">13:00 - 19:00 WIB</span>
                        </div>
                        <a href="#janji" class="btn btn-primary btn-sm">
                            <i class="fas fa-calendar-check"></i> Buat Janji
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         APPOINTMENT FORM SECTION
         ============================================ -->
    <section class="appointment" id="janji">
        <div class="container">
            <div class="appointment-wrapper">
                <!-- Left Side - Info -->
                <div class="appointment-info">
                    <span class="section-subtitle light">Buat Janji Temu</span>
                    <h2 class="section-title light">Reservasi Jadwal <span class="highlight">Konsultasi</span> Anda</h2>
                    <p class="appointment-description">
                        Isi formulir di samping untuk membuat janji temu dengan dokter pilihan Anda.
                        Tim kami akan mengkonfirmasi jadwal melalui WhatsApp/Email dalam 1x24 jam.
                    </p>
                    <div class="appointment-benefits">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4>Tanpa Antri Lama</h4>
                                <p>Datang sesuai jadwal, langsung dilayani</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div>
                                <h4>Pengingat Otomatis</h4>
                                <p>Notifikasi H-1 via WhatsApp</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-redo"></i>
                            </div>
                            <div>
                                <h4>Reschedule Gratis</h4>
                                <p>Ubah jadwal tanpa biaya tambahan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Form -->
                <div class="appointment-form-wrapper">
                    <form class="appointment-form" id="appointmentForm" novalidate>
                        <h3 class="form-title">Formulir Pendaftaran</h3>

                        <!-- Form Row 1 -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="patientName" class="form-label">
                                    Nama Lengkap <span class="required">*</span>
                                </label>
                                <input type="text" id="patientName" name="patientName"
                                       class="form-input" placeholder="Masukkan nama lengkap" required>
                                <span class="form-error" id="nameError"></span>
                            </div>
                            <div class="form-group">
                                <label for="patientEmail" class="form-label">
                                    Email <span class="required">*</span>
                                </label>
                                <input type="email" id="patientEmail" name="patientEmail"
                                       class="form-input" placeholder="email@contoh.com" required>
                                <span class="form-error" id="emailError"></span>
                            </div>
                        </div>

                        <!-- Form Row 2 -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="patientPhone" class="form-label">
                                    No. Telepon/WA <span class="required">*</span>
                                </label>
                                <input type="tel" id="patientPhone" name="patientPhone"
                                       class="form-input" placeholder="08xxxxxxxxxx" required>
                                <span class="form-error" id="phoneError"></span>
                            </div>
                            <div class="form-group">
                                <label for="appointmentDate" class="form-label">
                                    Tanggal Kunjungan <span class="required">*</span>
                                </label>
                                <input type="date" id="appointmentDate" name="appointmentDate"
                                       class="form-input" required>
                                <span class="form-error" id="dateError"></span>
                            </div>
                        </div>

                        <!-- Form Row 3 -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="serviceSelect" class="form-label">
                                    Pilih Poli/Layanan <span class="required">*</span>
                                </label>
                                <select id="serviceSelect" name="serviceSelect" class="form-input form-select" required>
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
                                <label for="doctorSelect" class="form-label">
                                    Pilih Dokter
                                </label>
                                <select id="doctorSelect" name="doctorSelect" class="form-input form-select">
                                    <option value="">-- Pilih Dokter --</option>
                                    <option value="fauzi">dr. Ahmad Fauzi, Sp.PD</option>
                                    <option value="nurhaliza">dr. Siti Nurhaliza, Sp.A</option>
                                    <option value="santoso">drg. Budi Santoso, Sp.Ort</option>
                                    <option value="rina">dr. Rina Wati, Sp.JP</option>
                                </select>
                            </div>
                        </div>

                        <!-- Form Row 4 - Notes -->
                        <div class="form-group full-width">
                            <label for="patientNotes" class="form-label">
                                Keluhan / Catatan Tambahan
                            </label>
                            <textarea id="patientNotes" name="patientNotes" class="form-input form-textarea"
                                      rows="4" placeholder="Jelaskan keluhan atau catatan khusus..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg btn-full" id="submitBtn">
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Pendaftaran</span>
                        </button>

                        <!-- Success Message (Hidden by default) -->
                        <div class="form-success" id="formSuccess">
                            <i class="fas fa-check-circle"></i>
                            <h4>Pendaftaran Berhasil!</h4>
                            <p>Tim kami akan menghubungi Anda dalam 1x24 jam untuk konfirmasi jadwal.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================
         FOOTER
         ============================================ -->
    <footer class="footer" id="kontak">
        <div class="container">
            <div class="footer-grid">
                <!-- Footer Column 1 - About -->
                <div class="footer-col">
                    <div class="footer-logo">
                        <div class="logo-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div class="logo-text">
                            <span class="logo-name">SehatSejahtera</span>
                            <span class="logo-tagline">Klinik Kesehatan Modern</span>
                        </div>
                    </div>
                    <p class="footer-about">
                        Klinik SehatSejahtera berkomitmen memberikan layanan kesehatan terbaik
                        dengan pendekatan personal dan teknologi medis terkini untuk kesejahteraan
                        Anda dan keluarga.
                    </p>
                    <div class="footer-socials">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Footer Column 2 - Quick Links -->
                <div class="footer-col">
                    <h4 class="footer-heading">Tautan Cepat</h4>
                    <ul class="footer-links">
                        <li><a href="#beranda"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                        <li><a href="#layanan"><i class="fas fa-chevron-right"></i> Layanan Kami</a></li>
                        <li><a href="#dokter"><i class="fas fa-chevron-right"></i> Tim Dokter</a></li>
                        <li><a href="#janji"><i class="fas fa-chevron-right"></i> Buat Janji</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Karir</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Footer Column 3 - Operating Hours -->
                <div class="footer-col">
                    <h4 class="footer-heading">Jam Operasional</h4>
                    <ul class="footer-hours">
                        <li>
                            <span>Senin - Jumat</span>
                            <strong>08:00 - 21:00</strong>
                        </li>
                        <li>
                            <span>Sabtu</span>
                            <strong>08:00 - 17:00</strong>
                        </li>
                        <li>
                            <span>Minggu</span>
                            <strong>09:00 - 14:00</strong>
                        </li>
                        <li class="hours-emergency">
                            <i class="fas fa-ambulance"></i>
                            <span>IGD 24 Jam</span>
                            <strong>Setiap Hari</strong>
                        </li>
                    </ul>
                </div>

                <!-- Footer Column 4 - Contact -->
                <div class="footer-col">
                    <h4 class="footer-heading">Hubungi Kami</h4>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. Kesehatan No. 123,<br>Jakarta Selatan 12345</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <a href="tel:+622112345678">(021) 123-4567</a>
                                <small>Telepon Klinik</small>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>
                                <a href="tel:+6281234567890" class="emergency-number">0812-3456-7890</a>
                                <small>Nomor Darurat 24 Jam</small>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <div>
                                <a href="mailto:info@sehatsejahtera.com">info@sehatsejahtera.com</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; 2024 Klinik SehatSejahtera. Seluruh hak cipta dilindungi undang-undang.</p>
                <p>Dibuat dengan <i class="fas fa-heart"></i> untuk kesehatan Indonesia</p>
            </div>
        </div>
    </footer>

    <!-- ================= PURE JS / ALPINE CHATBOT WIDGET ================= -->
    <div class="chatbot-widget">
        <!-- Floating Trigger Button -->
        <button type="button" class="chatbot-toggle" @click="chatOpen = !chatOpen">
            <span class="chatbot-toggle-icon">
                <i class="fas fa-comments"></i>
            </span>
            <span class="chatbot-badge" id="chatbotBadge">1</span>
            <span class="chatbot-pulse"></span>

        </button>

        <!-- Chat Modal Box -->
        <div class="chatbot-window" :class="{ 'open': chatOpen }">
            <div class="chatbot-header">
                <div class="chatbot-header-info">
                    <div class="chatbot-avatar"><i class="fas fa-robot"></i></div>
                    <div class="chatbot-header-text">
                        <h4>SehatBot Assistant</h4>
                        <span class="chatbot-status">Online - Siap Membantu</span>
                    </div>
                </div>
                <button type="button" class="chatbot-action-btn" @click="chatOpen = false"><i class="fas fa-times"></i></button>
            </div>

            <!-- Chat Messages Container -->
            <div class="chatbot-messages" id="chatMessagesArea">
                <template x-for="(msg, index) in chatMessages" :key="index">
                    <div class="message" :class="msg.sender">
                        <div class="message-bubble" x-html="msg.text"></div>
                    </div>
                </template>
            </div>

            <!-- Quick Reply Prompt Buttons -->
            <div class="chatbot-quick-replies">
                <button type="button" class="quick-reply-btn" @click="sendMessage('jam operasional')">
                    <i class="fas fa-clock"></i> Jam Buka
                </button>
                <button type="button" class="quick-reply-btn" @click="sendMessage('jadwal dokter')">
                    <i class="fas fa-user-md"></i> Jadwal Dokter
                </button>
                <button type="button" class="quick-reply-btn" @click="sendMessage('biaya')">
                    <i class="fas fa-money-bill-wave"></i> Biaya
                </button>
            </div>

            <!-- Chat Input Area (Form Client-Side Prevent) -->
            <div class="chatbot-input-area">
                <div class="chatbot-input-wrapper">
                    <input type="text" x-model="userText" @keydown.enter.prevent="sendMessage()" class="chatbot-input" placeholder="Ketik pertanyaan Anda...">
                    <button type="button" @click="sendMessage()" class="chatbot-send-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
