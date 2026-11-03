<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div x-data="{
        scrolled: false,
        mobileOpen: false,
        chatOpen: false,
        scrollTop: false
     }"
     x-init="
        window.addEventListener('scroll', () => {
            scrolled = window.pageYOffset > 50;
            scrollTop = window.pageYOffset > 500;
        });
     ">

    <!-- ================= HEADER / NAVBAR ================= -->
    <header class="header" :class="{ 'scrolled': scrolled }" id="header">
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

        <nav class="navbar" id="navbar">
            <div class="container">
                <div class="nav-wrapper">
                    <a href="#beranda" class="logo">
                        <div class="logo-icon"><i class="fas fa-heartbeat"></i></div>
                        <div class="logo-text">
                            <span class="logo-name">MutiaraKesehatan</span>
                            <span class="logo-tagline">Klinik Kesehatan Modern</span>
                        </div>
                    </a>

                    <ul class="nav-menu" :class="{ 'open': mobileOpen }" id="navMenu">
                        <li><a href="#beranda" @click="mobileOpen = false" class="nav-link active">Beranda</a></li>
                        <li><a href="#layanan" @click="mobileOpen = false" class="nav-link">Layanan</a></li>
                        <li><a href="#dokter" @click="mobileOpen = false" class="nav-link">Dokter</a></li>
                        <li><a href="#janji" @click="mobileOpen = false" class="nav-link">Buat Janji</a></li>
                        <li><a href="#kontak" @click="mobileOpen = false" class="nav-link">Kontak</a></li>
                    </ul>

                    <div class="nav-actions">
                        <a href="tel:+622112345678" class="btn-emergency">
                            <i class="fas fa-phone-alt"></i> <span>Darurat</span>
                        </a>
                        <button class="mobile-toggle" @click="mobileOpen = !mobileOpen" :class="{ 'active': mobileOpen }">
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
                <div class="hero-content">
                    <div class="hero-badge">
                        <i class="fas fa-shield-alt"></i> <span>Terakreditasi Paripurna KARS 2026</span>
                    </div>
                    <h1 class="hero-title">Kesehatan Anda,<br><span class="highlight">Prioritas Kami</span></h1>
                    <p class="hero-description">
                        Klinik MutiaraKesehatan hadir memberikan layanan kesehatan berkualitas tinggi
                        dengan teknologi medis terkini dan tim dokter spesialis berpengalaman.
                    </p>
                    <div class="hero-actions">
                        <a href="#janji" class="btn btn-primary btn-lg"><i class="fas fa-calendar-check"></i> Buat Janji Konsultasi</a>
                        <a href="#layanan" class="btn btn-outline btn-lg"><i class="fas fa-stethoscope"></i> Lihat Layanan</a>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-image-wrapper">
                        <div class="hero-image-placeholder">
                            <i class="fas fa-user-md"></i> <span>Tim Medis Profesional</span>
                        </div>
                        <div class="floating-card card-1">
                            <i class="fas fa-calendar-check"></i>
                            <div><strong>500+</strong><span>Pasien/Bulan</span></div>
                        </div>
                        <div class="floating-card card-2">
                            <i class="fas fa-star"></i>
                            <div><strong>4.9/5</strong><span>Rating Pasien</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= APPOINTMENT FORM ================= -->
    <section class="appointment" id="janji">
        <div class="container">
            <div class="appointment-wrapper">
                <div class="appointment-info">
                    <span class="section-subtitle light">Buat Janji Temu</span>
                    <h2 class="section-title light">Reservasi Jadwal <span class="highlight">Konsultasi</span> Anda</h2>
                    <p class="appointment-description">
                        Isi formulir di samping untuk membuat janji temu dengan dokter pilihan Anda.
                    </p>
                </div>

                <div class="appointment-form-wrapper">
                    <form wire:submit.prevent="submitAppointment" class="appointment-form" novalidate>
                        <h3 class="form-title">Formulir Pendaftaran</h3>

                        @if($isSuccess)
                            <div class="form-success show">
                                <i class="fas fa-check-circle"></i>
                                <h4>Pendaftaran Berhasil!</h4>
                                <p>Kode Booking Anda: <strong>{{ $bookingCode }}</strong></p>
                            </div>
                        @else
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                    <input type="text" wire:model="patientName" class="form-input @error('patientName') error @enderror" placeholder="Masukkan nama lengkap">
                                    @error('patientName') <span class="form-error">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email <span class="required">*</span></label>
                                    <input type="email" wire:model="patientEmail" class="form-input @error('patientEmail') error @enderror" placeholder="email@contoh.com">
                                    @error('patientEmail') <span class="form-error">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">No. Telepon/WA <span class="required">*</span></label>
                                    <input type="tel" wire:model="patientPhone" class="form-input @error('patientPhone') error @enderror" placeholder="08xxxxxxxxxx">
                                    @error('patientPhone') <span class="form-error">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tanggal Kunjungan <span class="required">*</span></label>
                                    <input type="date" wire:model="appointmentDate" min="{{ date('Y-m-d') }}" class="form-input @error('appointmentDate') error @enderror">
                                    @error('appointmentDate') <span class="form-error">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Pilih Poli/Layanan <span class="required">*</span></label>
                                    <select wire:model="serviceSelect" class="form-input form-select @error('serviceSelect') error @enderror">
                                        <option value="">-- Pilih Layanan --</option>
                                        <option value="umum">Poliklinik Umum</option>
                                        <option value="gigi">Klinik Gigi</option>
                                        <option value="anak">Klinik Anak</option>
                                        <option value="jantung">Klinik Jantung</option>
                                    </select>
                                    @error('serviceSelect') <span class="form-error">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Pilih Dokter</label>
                                    <select wire:model="selectedDoctor" class="form-input form-select">
                                        <option value="">-- Pilih Dokter --</option>
                                        @foreach($doctors as $doc)
                                            <option value="{{ $doc->id }}">{{ $doc->user->name }} ({{ $doc->specialization }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label">Keluhan / Catatan Tambahan</label>
                                <textarea wire:model="patientNotes" class="form-input form-textarea" rows="3" placeholder="Jelaskan keluhan singkat..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-full" wire:loading.attr="disabled">
                                <span wire:loading.remove><i class="fas fa-paper-plane"></i> Kirim Pendaftaran</span>
                                <span wire:loading><i class="fas fa-spinner fa-spin"></i> Mengirim...</span>
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= CHATBOT WIDGET ================= -->
    <div class="chatbot-widget">
        <button class="chatbot-toggle" @click="chatOpen = !chatOpen" :class="{ 'active': chatOpen }">
            <span class="chatbot-toggle-icon"><i class="fas fa-comments"></i></span>
            <span class="chatbot-badge">1</span>
        </button>

        <div class="chatbot-window" :class="{ 'open': chatOpen }">
            <div class="chatbot-header">
                <div class="chatbot-header-info">
                    <div class="chatbot-avatar"><i class="fas fa-robot"></i></div>
                    <div class="chatbot-header-text">
                        <h4>SehatBot Assistant</h4>
                        <span class="chatbot-status"><span class="status-indicator online"></span> Online</span>
                    </div>
                </div>
                <button class="chatbot-action-btn" @click="chatOpen = false"><i class="fas fa-times"></i></button>
            </div>

            <div class="chatbot-messages" id="chatArea">
                @foreach($chatMessages as $msg)
                    <div class="message {{ $msg['sender'] }}">
                        <div class="message-avatar"><i class="fas {{ $msg['sender'] === 'bot' ? 'fa-robot' : 'fa-user' }}"></i></div>
                        <div>
                            <div class="message-bubble">{!! $msg['text'] !!}</div>
                            <span class="message-time">{{ $msg['time'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="chatbot-quick-replies">
                <button type="button" wire:click="quickReply('jam operasional')" class="quick-reply-btn"><i class="fas fa-clock"></i> Jam Buka</button>
                <button type="button" wire:click="quickReply('jadwal dokter')" class="quick-reply-btn"><i class="fas fa-user-md"></i> Jadwal Dokter</button>
                <button type="button" wire:click="quickReply('biaya')" class="quick-reply-btn"><i class="fas fa-money-bill-wave"></i> Biaya</button>
            </div>

            <form wire:submit.prevent="sendChatMessage" class="chatbot-input-area">
                <div class="chatbot-input-wrapper">
                    <input type="text" wire:model="userMessage" class="chatbot-input" placeholder="Ketik pertanyaan...">
                    <button type="submit" class="chatbot-send-btn"><i class="fas fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scroll to top button -->
    <button class="scroll-top" :class="{ 'visible': scrollTop }" @click="window.scrollTo({ top: 0, behavior: 'smooth' })">
        <i class="fas fa-chevron-up"></i>
    </button>
</div>
