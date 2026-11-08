<?php

namespace App\Livewire\Public;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Appointment;
use Livewire\Component;
use Illuminate\Support\Str;
use Throwable;

class BookingWizard extends Component
{
    // Form Inputs
    public $selectedDoctor = null; // Bisa berisi Doctor ID atau User ID
    public $selectedDate = '';
    public $selectedTime = '';
    public $complaint = '';

    // Data Collections
    public $doctors = [];
    public $availableSchedule = [];

    // Notifications
    public $successMessage = '';
    public $errorMessage = '';

    // Chatbot States
    public $messages = [];
    public $userMessage = '';

    public function mount()
    {
        // 1. Load Data Dokter beserta relasi User
        $this->doctors = Doctor::with('user')->get();

        // 2. Tangkap Query Parameters dari URL (Landing Page)
        $doctorIdParam = request()->query('doctor_id');
        $date = request()->query('date');
        $notes = request()->query('notes');

        if ($date) {
            $this->selectedDate = $date;
        }

        if ($notes) {
            $this->complaint = $notes;
        }

        if ($doctorIdParam) {
            $this->resolveAndLoadDoctor($doctorIdParam);
        }

        // 3. Pesan Awal Chatbot
        $this->messages = [
            [
                'sender' => 'bot',
                'text'   => "Halo! 👋 Selamat datang di Booking Wizard Klinik MutiaraKesehatan.\nAda yang bisa kami bantu terkait jadwal dokter atau konfirmasi janji temu?"
            ]
        ];
    }

    public function updatedSelectedDoctor($value)
    {
        $this->resolveAndLoadDoctor($value);
    }

    /**
     * Resolusi ID: Memastikan ID yang diproses adalah Doctor ID (bukan User ID)
     * Rantai Relasi: DoctorSchedule -> doctor_id -> Doctor -> user_id -> User
     */
    private function resolveAndLoadDoctor($idInput)
    {
        $this->selectedTime = '';

        if (!$idInput) {
            $this->availableSchedule = [];
            return;
        }

        // 1. Cek apakah ID input adalah Primary Key dari tabel Doctor
        $doctor = Doctor::find($idInput);

        // 2. Jika tidak ditemukan, cari apakah ID input adalah user_id di tabel Doctor
        if (!$doctor) {
            $doctor = Doctor::where('user_id', $idInput)->first();
        }

        if ($doctor) {
            // Set selectedDoctor ke ID Doctor yang valid
            $this->selectedDoctor = $doctor->id;

            // Ambil jadwal langsung dari DoctorSchedule menggunakan Doctor ID
            $this->availableSchedule = DoctorSchedule::where('doctor_id', $doctor->id)->get();
        } else {
            $this->availableSchedule = [];
        }
    }

    public function submitBooking()
    {
        $this->resetErrorBag();
        $this->successMessage = '';
        $this->errorMessage = '';

        $this->validate([
            'selectedDoctor' => 'required',
            'selectedDate'   => 'required|date|after_or_equal:today',
            'selectedTime'   => 'required',
            'complaint'      => 'nullable|string|max:500',
        ], [
            'selectedDoctor.required' => 'Dokter spesialis wajib dipilih.',
            'selectedDate.required'   => 'Tanggal kunjungan wajib diisi.',
            'selectedDate.after_or_equal' => 'Tanggal kunjungan tidak boleh lewat dari hari ini.',
            'selectedTime.required'   => 'Silakan pilih salah satu jadwal praktik yang tersedia.',
        ]);

        try {
            // Resolusi ulang untuk memastikan Doctor ID yang disimpan ke tabel appointments valid
            $doctor = Doctor::find($this->selectedDoctor) ?? Doctor::where('user_id', $this->selectedDoctor)->first();

            if (!$doctor) {
                $this->errorMessage = 'Data dokter tidak ditemukan dalam sistem.';
                return;
            }

            // Simpan data reservasi ke tabel appointments
            $appointment = Appointment::create([
                'appointment_code' => 'APT-' . strtoupper(Str::random(6)),
                'patient_id'        => auth()->user()?->patient?->id ?? auth()->id(),
                'doctor_id'         => $doctor->id, // Menggunakan ID dari tabel Doctors
                'appointment_date' => $this->selectedDate,
                'appointment_time' => $this->selectedTime,
                'booking_source'    => 'web',
                'status'            => 'pending',
                'complaint'         => $this->complaint,
            ]);

            $this->successMessage = 'Janji temu sudah di reservasi! Kode Booking Anda: ' . $appointment->appointment_code;
            session()->flash('message', $this->successMessage);

            // Reset pilihan jam & keluhan
            $this->reset(['selectedTime', 'complaint']);

        } catch (Throwable $e) {
            $this->errorMessage = 'Gagal menyimpan reservasi: ' . $e->getMessage();
        }
    }

    // Interactive Chatbot Handlers
    public function sendMessage()
    {
        $msg = trim($this->userMessage);
        if ($msg === '') return;

        $this->messages[] = [
            'sender' => 'user',
            'text'   => $msg
        ];

        $input = strtolower($msg);
        $this->userMessage = '';

        if (str_contains($input, 'jadwal') || str_contains($input, 'dokter')) {
            $reply = "👨‍⚕️ Jadwal praktik dokter yang tersedia dapat Anda pilih langsung pada form langkah 1.";
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
        return view('components.public.booking-wizard')
            ->layout('layouts.app');
    }
}
