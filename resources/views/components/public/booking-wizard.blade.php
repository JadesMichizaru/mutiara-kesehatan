<!-- Font Awesome CDN resmi agar ikon tampil utuh -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .rs-wizard-wrapper * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif;
    }

    .rs-wizard-wrapper {
        background-color: #f0f4f8;
        background-image: radial-gradient(#cbd5e1 0.8px, transparent 0.8px);
        background-size: 16px 16px;
        min-height: 100vh;
        padding: 40px 16px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .rs-container {
        width: 100%;
        max-width: 900px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .rs-header-card {
        background: linear-gradient(135deg, #0f766e 0%, #0f172a 100%);
        color: #ffffff;
        border-radius: 20px;
        padding: 26px 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 10px 25px -5px rgba(15, 118, 110, 0.25);
    }

    .rs-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        color: #5eead4;
        border: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 8px;
    }

    .rs-header-title { font-size: 24px; font-weight: 800; color: #ffffff; }
    .rs-header-sub { font-size: 13px; color: #94a3b8; margin-top: 4px; }

    .btn-back-home {
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
        text-decoration: none;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .rs-alert-success {
        background-color: #ecfdf5; border: 1.5px solid #a7f3d0; color: #065f46;
        padding: 16px 20px; border-radius: 16px; display: flex; align-items: center; gap: 12px;
        font-size: 14px; font-weight: 700;
    }

    .rs-alert-error {
        background-color: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c;
        padding: 16px 20px; border-radius: 16px; display: flex; align-items: center; gap: 12px;
        font-size: 14px; font-weight: 700;
    }

    .rs-form-card {
        background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05); padding: 32px;
    }

    .rs-section-title {
        font-size: 16px; font-weight: 700; color: #1e293b; display: flex;
        align-items: center; gap: 12px; padding-bottom: 12px; border-bottom: 2px solid #f1f5f9; margin-bottom: 20px;
    }

    .rs-step-num {
        width: 32px; height: 32px; background-color: #0d9488; color: #ffffff;
        border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 800;
    }

    .rs-form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px; }
    .rs-form-group { display: flex; flex-direction: column; gap: 8px; }
    .rs-label { font-size: 13px; font-weight: 700; color: #334155; }
    .rs-label span.req { color: #e11d48; }

    .rs-input, .rs-select, .rs-textarea {
        width: 100%; padding: 12px 16px; border-radius: 12px; border: 1.5px solid #cbd5e1;
        background-color: #f8fafc; font-size: 14px; color: #0f172a; outline: none;
    }

    .rs-schedule-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 12px; margin-top: 8px; }
    .rs-schedule-card {
        display: flex; align-items: center; gap: 12px; padding: 14px 16px;
        background-color: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; cursor: pointer; transition: all 0.2s ease;
    }
    .rs-schedule-card.selected { border-color: #0d9488; background-color: #f0fdf4; }
    .rs-schedule-card input[type="radio"] { accent-color: #0d9488; width: 18px; height: 18px; }
    .rs-schedule-time { font-size: 13px; font-weight: 700; color: #0f172a; }
    .rs-schedule-sub { font-size: 12px; color: #64748b; }

    .rs-empty-schedule {
        background-color: #f8fafc; border: 2px dashed #cbd5e1; padding: 24px;
        border-radius: 14px; text-align: center; color: #64748b; font-size: 13px;
    }

    .rs-submit-wrapper { display: flex; justify-content: flex-end; margin-top: 28px; }
    .btn-rs-submit {
        background-color: #0d9488; color: #ffffff; font-size: 14px; font-weight: 700;
        padding: 14px 28px; border-radius: 12px; border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 14px rgba(13, 148, 136, 0.3);
    }
    .rs-error { color: #e11d48; font-size: 12px; font-weight: 600; }

    /* Floating Chatbot Widget */
    .rs-chatbot-trigger {
        position: fixed; bottom: 24px; right: 24px; z-index: 999;
        background-color: #0f766e; color: white; border: none; padding: 14px 22px;
        border-radius: 50px; font-weight: 700; font-size: 14px; box-shadow: 0 10px 25px -5px rgba(15, 118, 110, 0.4);
        cursor: pointer; display: flex; align-items: center; gap: 10px;
    }
    .rs-chatbot-window {
        position: fixed; bottom: 84px; right: 24px; width: 360px;
        background-color: #ffffff; border-radius: 20px; box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.15);
        border: 1px solid #e2e8f0; overflow: hidden; z-index: 999;
    }
    .chat-scroll-area { padding: 16px; height: 280px; overflow-y: auto; background-color: #f8fafc; display: flex; flex-direction: column; gap: 10px; }
</style>

<div class="rs-wizard-wrapper">
    <div class="rs-container">

        <!-- Banner Header RS -->
        <div class="rs-header-card">
            <div>
                <div class="rs-badge">
                    <i class="fa-solid fa-hospital"></i> PORTAL RESERVASI JANJI TEMU MEDIS
                </div>
                <h1 class="rs-header-title">Konfirmasi & Detail Pendaftaran</h1>
                <p class="rs-header-sub">Lengkapi jadwal serta konfirmasi data medis pasien sebelum diterbitkan nomor antrean.</p>
            </div>
            <a href="/" class="btn-back-home">
                <i class="fa-solid fa-arrow-left"></i> Beranda
            </a>
        </div>

        <!-- Flash Notifikasi Sukses -->
        @if ($successMessage || session()->has('message'))
            <div class="rs-alert-success">
                <i class="fa-solid fa-circle-check" style="font-size: 20px;"></i>
                <div>{{ $successMessage ?: session('message') }}</div>
            </div>
        @endif

        <!-- Flash Notifikasi Error -->
        @if ($errorMessage)
            <div class="rs-alert-error">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 20px;"></i>
                <div>{{ $errorMessage }}</div>
            </div>
        @endif

        <!-- Form Card Utama -->
        <div class="rs-form-card">
            <form wire:submit.prevent="submitBooking">

                <!-- Section 1 -->
                <div style="margin-bottom: 28px;">
                    <div class="rs-section-title">
                        <span class="rs-step-num">1</span>
                        <span>Pilih Dokter & Waktu Praktik</span>
                    </div>

                    <div class="rs-form-grid">
                        <div class="rs-form-group">
                            <label class="rs-label">Dokter Spesialis <span class="req">*</span></label>
                            <select wire:model.live="selectedDoctor" class="rs-select">
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}">{{ $doc->user->name ?? $doc->name }} ({{ $doc->specialty ?? $doc->specialization ?? 'Dokter Spesialis' }})</option>
                                @endforeach
                            </select>
                            @error('selectedDoctor') <span class="rs-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="rs-form-group">
                            <label class="rs-label">Tanggal Kunjungan <span class="req">*</span></label>
                            <input type="date" wire:model="selectedDate" class="rs-input">
                            @error('selectedDate') <span class="rs-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Direct DoctorSchedule Selection -->
                    <div class="rs-form-group">
                        <label class="rs-label">Jadwal Praktik Dokter Available (Tabel DoctorSchedule) <span class="req">*</span></label>
                        @if(count($availableSchedule) > 0)
                            <div class="rs-schedule-grid">
                                @foreach($availableSchedule as $sch)
                                    <label class="rs-schedule-card {{ $selectedTime == ($sch->start_time . ' - ' . $sch->end_time) ? 'selected' : '' }}">
                                        <input type="radio" wire:model="selectedTime" value="{{ $sch->start_time }} - {{ $sch->end_time }}">
                                        <div>
                                            <div class="rs-schedule-time">{{ $sch->day_of_week ?? $sch->day }}</div>
                                            <div class="rs-schedule-sub">
                                                <i class="fa-regular fa-clock"></i> {{ $sch->start_time }} - {{ $sch->end_time }} WIB
                                                @if(isset($sch->quota))
                                                    <span style="font-size: 11px; color: #0d9488; font-weight: 700;">(Kuota: {{ $sch->quota }})</span>
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="rs-empty-schedule">
                                <i class="fa-solid fa-calendar-xmark" style="font-size: 26px; margin-bottom: 8px; color: #94a3b8;"></i><br>
                                {{ $selectedDoctor ? 'Belum ada jadwal praktik terdaftar pada tabel DoctorSchedule untuk dokter ini.' : 'Silakan pilih dokter terlebih dahulu untuk menampilkan data jadwal.' }}
                            </div>
                        @endif
                        @error('selectedTime') <span class="rs-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Section 2 -->
                <div>
                    <div class="rs-section-title">
                        <span class="rs-step-num">2</span>
                        <span>Keluhan & Catatan Medis Pasien</span>
                    </div>

                    <div class="rs-form-group">
                        <label class="rs-label">Keluhan Utama / Gejala</label>
                        <textarea wire:model="complaint" rows="3" class="rs-textarea" placeholder="Jelaskan keluhan singkat Anda..."></textarea>
                        @error('complaint') <span class="rs-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="rs-submit-wrapper">
                    <button type="submit" class="btn-rs-submit">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Konfirmasi & Buat Janji Temu</span>
                    </button>
                </div>

            </form>
        </div>

    </div>

    <!-- Floating Chatbot Widget -->
    <div x-data="{ open: false }">
        <button @click="open = !open" class="rs-chatbot-trigger">
            <i class="fa-solid fa-comments"></i>
            <span>Tanya Jadwal</span>
        </button>

        <div x-show="open" x-transition class="rs-chatbot-window" style="display: none;">
            <div style="background-color: #0f172a; color: white; padding: 14px 16px; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-robot" style="color: #5eead4; font-size: 18px;"></i>
                    <div>
                        <h4 style="font-size: 13px; font-weight: 700;">Bot Informasi Dokter</h4>
                        <p style="font-size: 11px; color: #94a3b8;">Respon Otomatis Sistem</p>
                    </div>
                </div>
                <button @click="open = false" style="background: none; border: none; color: white; font-weight: bold; cursor: pointer; font-size: 18px;">×</button>
            </div>

            <div class="chat-scroll-area">
                @foreach($messages ?? [] as $msg)
                    <div style="display: flex; justify-content: {{ ($msg['sender'] ?? 'bot') === 'user' ? 'flex-end' : 'flex-start' }};">
                        <div style="max-width: 85%; padding: 10px 14px; border-radius: 14px; font-size: 12px; line-height: 1.4; {{ ($msg['sender'] ?? 'bot') === 'user' ? 'background-color: #0d9488; color: white;' : 'background-color: white; color: #1e293b; border: 1px solid #e2e8f0;' }}">
                            {!! nl2br(e($msg['text'] ?? '')) !!}
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="padding: 8px; background: white; border-top: 1px solid #e2e8f0; display: flex; gap: 6px; overflow-x: auto;">
                <button type="button" wire:click="quickPrompt('jadwal dokter hari ini')" style="white-space: nowrap; background-color: #ccfbf1; color: #0f766e; border: 1px solid #99f6e4; padding: 6px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; cursor: pointer;">
                    <i class="fa-regular fa-calendar-check"></i> Jadwal Dokter
                </button>
                <button type="button" wire:click="quickPrompt('biaya berobat')" style="white-space: nowrap; background-color: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; padding: 6px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; cursor: pointer;">
                    <i class="fa-solid fa-money-bill-wave"></i> Biaya Berobat
                </button>
            </div>

            <form wire:submit.prevent="sendMessage" style="padding: 10px; background-color: white; border-top: 1px solid #e2e8f0; display: flex; gap: 8px;">
                <input type="text" wire:model="userMessage" placeholder="Ketik pertanyaan..." style="flex: 1; font-size: 12px; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 10px; outline: none;">
                <button type="submit" style="background-color: #0d9488; color: white; border: none; padding: 8px 14px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>
