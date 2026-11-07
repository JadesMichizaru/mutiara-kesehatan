<?php

namespace App\Livewire\Public;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Appointment;
use Livewire\Component;
use Illuminate\Support\Str;

class BookingWizard extends Component
{
    // Form Inputs
    public $selectedDoctor = null;
    public $selectedDate = '';
    public $selectedTime = '';
    public $complaint = '';

    // Data Collections
    public $doctors = [];
    public $availableSchedules = [];

    // Chat Widget States (Mencegah Undefined Variable $messages)
    public $messages = [];
    public $userMessage = '';

    public function mount()
    {
        // 1. Load Data Dokter
        $this->doctors = Doctor::with('user')->get();

        // 2. Catch Query String Params dari Landing Page (Redirect Result)
        $doctorId = request()->query('doctor_id');
        $date = request()->query('date');
        $notes = request()->query('notes');

        if ($doctorId) {
            $this->selectedDoctor = $doctorId;
            $this->updatedSelectedDoctor($doctorId);
        }

        if ($date) {
            $this->selectedDate = $date;
        }

        if ($notes) {
            $this->complaint = $notes;
        }

        // 3. Inisialisasi Pesan Default Chat Bot
        $this->messages = [
            [
                'sender' => 'bot',
                'text'   => "Halo! 👋 Selamat datang di Booking Wizard Klinik MutiaraKesehatan.\nAda yang bisa kami bantu terkait jadwal dokter atau konfirmasi janji temu?"
            ]
        ];
    }

    public function updatedSelectedDoctor($doctorId)
    {
        if ($doctorId) {
            $this->availableSchedules = DoctorSchedule::where('doctor_id', $doctorId)->get();
        } else {
            $this->availableSchedules = [];
        }
    }

    public function submitBooking()
    {
        $this->validate([
            'selectedDoctor' => 'required',
            'selectedDate'   => 'required|date|after_or_equal:today',
            'selectedTime'   => 'required',
            'complaint'      => 'nullable|string|max:500',
        ]);

        // Simpan janji temu
        $appointment = Appointment::create([
            'appointment_code' => 'APT-' . strtoupper(Str::random(6)),
            'patient_id'        => auth()->user()?->patient?->id ?? auth()->id(),
            'doctor_id'         => $this->selectedDoctor,
            'appointment_date' => $this->selectedDate,
            'appointment_time' => $this->selectedTime,
            'booking_source'    => 'web',
            'status'            => 'pending',
            'complaint'         => $this->complaint,
        ]);

        session()->flash('message', 'Janji temu berhasil dibuat! Kode Booking Anda: ' . $appointment->appointment_code);
        $this->reset(['selectedDoctor', 'selectedDate', 'selectedTime', 'complaint']);
    }

    // Handler untuk Interactive Chat Bot di Modal Wizard
    public function sendMessage()
    {
        if (trim($this->userMessage) === '') return;

        $this->messages[] = [
            'sender' => 'user',
            'text'   => $this->userMessage
        ];

        $input = strtolower($this->userMessage);
        $this->userMessage = '';

        if (str_contains($input, 'jadwal') || str_contains($input, 'dokter')) {
            $reply = "👨‍⚕️ Jadwal praktik dokter dapat Anda pilih langsung pada form langkah 1 di layar ini.";
        } elseif (str_contains($input, 'biaya') || str_contains($input, 'tarif')) {
            $reply = "💰 Estimasi biaya konsultasi spesialis berkisar antara Rp 150.000 - Rp 300.000 (Menerima BPJS & Asuransi).";
        } else {
            $reply = "Terima kasih atas pertanyaan Anda. Silakan lanjutkan pengisian form pendaftaran janji temu.";
        }

        $this->messages[] = [
            'sender' => 'bot',
            'text'   => $reply
        ];
    }

    public function quickPrompt($prompt)
    {
        $this->userMessage = $prompt;
        $this->sendMessage();
    }

    public function render()
    {
        return view('components.public.booking-wizard');
    }
}
