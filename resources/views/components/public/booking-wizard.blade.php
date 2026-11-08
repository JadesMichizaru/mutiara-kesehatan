@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .mk-booking-wizard {
        --mk-teal: #0d9488;
        --mk-teal-dark: #0f766e;
        --mk-navy: #1e293b;
        --mk-slate: #64748b;
        --mk-light: #f8fafc;
        --mk-white: #ffffff;
        --mk-danger: #ef4444;
        --mk-success: #10b981;

        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: var(--mk-navy);
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .mk-card {
        background: var(--mk-white);
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .mk-card-header {
        background: linear-gradient(135deg, var(--mk-teal) 0%, var(--mk-navy) 100%);
        color: var(--mk-white);
        padding: 1.5rem;
        text-align: center;
    }

    .mk-card-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .mk-card-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .mk-card-body {
        padding: 2rem;
    }

    .mk-form-group {
        margin-bottom: 1.5rem;
    }

    .mk-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--mk-navy);
        font-size: 0.9rem;
    }

    .mk-input, .mk-select, .mk-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s;
        background-color: var(--mk-light);
    }

    .mk-input:focus, .mk-select:focus, .mk-textarea:focus {
        outline: none;
        border-color: var(--mk-teal);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
    }

    .mk-textarea {
        min-height: 100px;
        resize: vertical;
    }

    .mk-schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .mk-schedule-item {
        position: relative;
    }

    .mk-schedule-item input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .mk-schedule-label {
        display: flex;
        flex-direction: column;
        padding: 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        background: var(--mk-white);
    }

    .mk-schedule-item input[type="radio"]:checked + .mk-schedule-label {
        border-color: var(--mk-teal);
        background-color: rgba(13, 148, 136, 0.05);
    }

    .mk-schedule-day {
        font-weight: 700;
        color: var(--mk-navy);
        margin-bottom: 0.25rem;
    }

    .mk-schedule-time {
        font-size: 0.9rem;
        color: var(--mk-slate);
    }

    .mk-schedule-quota {
        font-size: 0.8rem;
        color: var(--mk-teal-dark);
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .mk-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1rem;
    }

    .mk-btn-primary {
        background-color: var(--mk-teal);
        color: var(--mk-white);
        width: 100%;
    }

    .mk-btn-primary:hover {
        background-color: var(--mk-teal-dark);
    }

    .mk-btn-primary:disabled {
        background-color: var(--mk-slate);
        cursor: not-allowed;
        opacity: 0.7;
    }

    .mk-alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .mk-alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .mk-alert-error {
        background-color: rgba(239, 68, 68, 0.1);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* Chatbot Widget */
    .mk-chatbot-widget {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 9999;
    }

    .mk-chatbot-toggle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: var(--mk-teal);
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: transform 0.2s;
    }

    .mk-chatbot-toggle:hover {
        transform: scale(1.05);
    }

    .mk-chatbot-window {
        position: absolute;
        bottom: 80px;
        right: 0;
        width: 350px;
        height: 450px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .mk-chatbot-header {
        background: var(--mk-navy);
        color: white;
        padding: 1rem;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .mk-chatbot-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        background-color: #f1f5f9;
    }

    .mk-chat-message {
        max-width: 85%;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        font-size: 0.9rem;
        line-height: 1.4;
        word-wrap: break-word;
    }

    .mk-chat-message.bot {
        background-color: white;
        color: var(--mk-navy);
        align-self: flex-start;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .mk-chat-message.user {
        background-color: var(--mk-teal);
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }

    .mk-chatbot-input-area {
        padding: 1rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 0.5rem;
        background: white;
    }

    .mk-chatbot-input {
        flex: 1;
        padding: 0.5rem 0.75rem;
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        font-size: 0.9rem;
        outline: none;
    }

    .mk-chatbot-input:focus {
        border-color: var(--mk-teal);
    }

    .mk-chatbot-send {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--mk-teal);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mk-quick-prompts {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 0 1rem 1rem;
        background: #f1f5f9;
    }

    .mk-quick-btn {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        background: white;
        border: 1px solid var(--mk-teal);
        color: var(--mk-teal);
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .mk-quick-btn:hover {
        background: var(--mk-teal);
        color: white;
    }

    .mk-empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--mk-slate);
        background: #f8fafc;
        border-radius: 8px;
        border: 1px dashed #cbd5e1;
    }

    @media (max-width: 640px) {
        .mk-chatbot-window {
            width: calc(100vw - 2rem);
            right: -1rem;
        }
    }
</style>
@endpush

<div class="mk-booking-wizard" x-data="chatbotWidget()">
    <div class="mk-card">
        <div class="mk-card-header">
            <h2><i class="fa-solid fa-calendar-check"></i> PORTAL RESERVASI JANJI TEMU MEDIS</h2>
            <p>Konfirmasi & Detail Pendaftaran<br>Lengkapi jadwal serta konfirmasi data medis pasien sebelum diterbitkan nomor antrean.</p>
        </div>

        <div class="mk-card-body">
            @if (session()->has('successMessage'))
                <div class="mk-alert mk-alert-success">
                    <i class="fa-solid fa-circle-check fa-lg"></i>
                    <span>{{ session('successMessage') }}</span>
                </div>
            @endif

            @if (session()->has('errorMessage'))
                <div class="mk-alert mk-alert-error">
                    <i class="fa-solid fa-circle-exclamation fa-lg"></i>
                    <span>{{ session('errorMessage') }}</span>
                </div>
            @endif

            <!-- FORM BOOKING - HANYA untuk reservasi -->
            <form wire:submit="submitBooking">
                <div class="mk-form-group">
                    <label class="mk-label">1. PILIH DOKTER SPESIALIS *</label>
                    <select wire:model.live="selectedDoctor" class="mk-select">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">
                                {{ $doc->user->name ?? 'Dokter Tanpa Nama' }} ({{ $doc->specialization ?? 'Dokter Spesialis' }})
                            </option>
                        @endforeach
                    </select>
                    @error('selectedDoctor') <span style="color: var(--mk-danger); font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>

                <div class="mk-form-group">
                    <label class="mk-label">TANGGAL KUNJUNGAN *</label>
                    <input type="date" wire:model.live="selectedDate" class="mk-input">
                    @error('selectedDate') <span style="color: var(--mk-danger); font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>

                <div class="mk-form-group">
                    <label class="mk-label">JADWAL PRAKTIK DOKTER TERSEDIA *</label>
                    @if($resolvedDoctorId && count($availableSchedule) > 0)
                        <div class="mk-schedule-grid">
                            @foreach($availableSchedule as $sch)
                                <div class="mk-schedule-item">
                                    <input type="radio"
                                           id="schedule_{{ $sch->id }}"
                                           wire:model="selectedScheduleId"
                                           value="{{ $sch->id }}">
                                    <label for="schedule_{{ $sch->id }}" class="mk-schedule-label">
                                        <span class="mk-schedule-day">
                                            <i class="fa-regular fa-calendar"></i> {{ $sch->day_of_week }}
                                        </span>
                                        <span class="mk-schedule-time">
                                            <i class="fa-regular fa-clock"></i> {{ $sch->start_time }} - {{ $sch->end_time }} WIB
                                        </span>
                                        @if(isset($sch->quota))
                                            <span class="mk-schedule-quota">
                                                <i class="fa-solid fa-users"></i> Kuota: {{ $sch->quota }}
                                            </span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @elseif($resolvedDoctorId)
                        <div class="mk-empty-state">
                            <i class="fa-regular fa-calendar-xmark fa-2x" style="margin-bottom: 0.5rem;"></i>
                            <p>Belum ada jadwal praktik terdaftar untuk dokter ini.</p>
                        </div>
                    @else
                        <div class="mk-empty-state">
                            <p>Silakan pilih dokter terlebih dahulu untuk menampilkan data jadwal.</p>
                        </div>
                    @endif
                    @error('selectedScheduleId') <span style="color: var(--mk-danger); font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>

                <div class="mk-form-group">
                    <label class="mk-label">2. KELUHAN & CATATAN MEDIS PASIEN *</label>
                    <textarea wire:model="complaint" class="mk-textarea" placeholder="Jelaskan keluhan utama atau gejala yang dialami..."></textarea>
                    @error('complaint') <span style="color: var(--mk-danger); font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="mk-btn mk-btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove><i class="fa-solid fa-paper-plane"></i> Konfirmasi & Buat Janji Temu</span>
                    <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> Memproses...</span>
                </button>
            </form>
            <!-- AKHIR FORM BOOKING -->

        </div>
    </div>

    <!-- CHATBOT WIDGET - TERPISAH dari form -->
    <div class="mk-chatbot-widget">
        <div class="mk-chatbot-window" x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             style="display: none;">

            <div class="mk-chatbot-header">
                <span><i class="fa-solid fa-robot"></i> Bot Informasi Dokter</span>
                <button @click="open = false" style="background: none; border: none; color: white; cursor: pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="mk-chatbot-messages" x-ref="chatContainer">
                <template x-for="(msg, index) in messages" :key="index">
                    <div class="mk-chat-message" :class="msg.sender === 'bot' ? 'bot' : 'user'">
                        <span x-html="msg.text"></span>
                    </div>
                </template>
            </div>

            <div class="mk-quick-prompts">
                <button type="button" class="mk-quick-btn" @click="quickPrompt('Lihat jadwal dokter')">Lihat Jadwal</button>
                <button type="button" class="mk-quick-btn" @click="quickPrompt('Berapa biaya berobat?')">Biaya Berobat</button>
                <button type="button" class="mk-quick-btn" @click="quickPrompt('Cara batal reservasi')">Batal Reservasi</button>
            </div>

            <div class="mk-chatbot-input-area">
                <input type="text"
                       class="mk-chatbot-input"
                       placeholder="Ketik pesan Anda..."
                       x-model="input"
                       @keydown.enter.prevent="sendMessage()">
                <button type="button" class="mk-chatbot-send" @click="sendMessage()">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>

        <button type="button" class="mk-chatbot-toggle" @click="open = !open">
            <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-comments'"></i>
        </button>
    </div>
</div>

@push('scripts')
<script>
    function chatbotWidget() {
        return {
            open: false,
            messages: @json($chatMessages),
            input: '',

            init() {
                this.$nextTick(() => {
                    this.scrollToBottom();
                });

                // Listen untuk event scroll dari Livewire
                this.$wire.on('scroll-chat-to-bottom', () => {
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                });
            },

            sendMessage() {
                if (!this.input.trim()) return;

                // Tampilkan pesan user di UI
                this.messages.push({ sender: 'user', text: this.input });
                const userText = this.input;
                this.input = '';

                this.$nextTick(() => {
                    this.scrollToBottom();
                });

                // Panggil method Livewire KHUSUS untuk chatbot
                this.$wire.sendChatMessage();
            },

            quickPrompt(text) {
                // Panggil method Livewire untuk quick prompt
                this.$wire.quickPrompt(text);
            },

            scrollToBottom() {
                const container = this.$refs.chatContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }
        }
    }
</script>
@endpush
