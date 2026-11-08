<?php

namespace App\Livewire\Public;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;

class BookingWizard extends Component
{
    public $doctors;
    public $selectedDoctor = '';
    public $resolvedDoctorId = null;
    public $selectedDate = '';
    public $selectedScheduleId = '';
    public $complaint = '';
    public $availableSchedule = [];

    // Chatbot Properties
    public $chatOpen = false;
    public $chatMessages = [];
    public $chatInput = '';

    public function mount()
    {
        $this->doctors = Doctor::with('user')->get();

        $this->chatMessages = [
            ['sender' => 'bot', 'text' => 'Halo! Selamat datang di MutiaraKesehatan. Silakan pilih dokter di formulir, lalu tanyakan saya tentang <b>Jadwal Dokter</b>, <b>Biaya</b>, atau <b>Cara Batal</b>.']
        ];
    }

    public function updatedSelectedDoctor($value)
    {
        $this->reset(['selectedScheduleId', 'availableSchedule']);

        if (empty($value)) {
            $this->resolvedDoctorId = null;
            return;
        }

        // Resolusi ID: Cek apakah value adalah doctor_id atau user_id
        $doctor = Doctor::where('id', $value)
            ->orWhereHas('user', function ($query) use ($value) {
                $query->where('id', $value);
            })->first();

        if ($doctor) {
            $this->resolvedDoctorId = $doctor->id;
            $this->loadSchedules();
        } else {
            $this->resolvedDoctorId = null;
            $this->availableSchedule = [];
        }
    }

    public function loadSchedules()
    {
        if (!$this->resolvedDoctorId) return;

        $this->availableSchedule = DoctorSchedule::where('doctor_id', $this->resolvedDoctorId)
            ->orderByRaw("CASE day_of_week
                WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3
                WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7
            END")
            ->get();
    }

    // METHOD UNTUK FORM BOOKING (hanya dipanggil saat submit form)
    public function submitBooking()
    {
        $this->validate([
            'selectedDoctor' => 'required|exists:doctors,id',
            'selectedScheduleId' => 'required|exists:doctor_schedule,id',
            'complaint' => 'required|string|min:10',
        ]);

        try {
            DB::beginTransaction();

            $bookingCode = 'APT-' . strtoupper(Str::random(6));
            $userId = Auth::id() ?: null;

            Appointment::create([
                'user_id'       => $userId,
                'doctor_id'     => $this->resolvedDoctorId,
                'schedule_id'   => $this->selectedScheduleId,
                'complaint'     => $this->complaint,
                'booking_code'  => $bookingCode,
                'status'        => 'pending',
                'appointment_date' => $this->selectedDate ?: now()->toDateString(),
            ]);

            DB::commit();
            Session::flash('successMessage', "Janji temu sudah di reservasi! Kode Booking Anda: {$bookingCode}");

            $this->reset(['selectedDoctor', 'resolvedDoctorId', 'selectedDate', 'selectedScheduleId', 'complaint', 'availableSchedule']);

        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('errorMessage', 'Gagal melakukan reservasi: ' . $e->getMessage());
        }
    }

    // METHOD KHUSUS CHATBOT (TERPISAH dari submitBooking)
    public function sendChatMessage()
    {
        if (empty(trim($this->chatInput))) return;

        // Simpan pesan user
        $userMessage = trim($this->chatInput);
        $this->chatMessages[] = ['sender' => 'user', 'text' => $userMessage];

        $userText = strtolower($userMessage);
        $this->chatInput = ''; // Kosongkan input

        // Dispatch event untuk auto-scroll
        $this->dispatch('scroll-chat-to-bottom');

        // Logika respon chatbot
        $response = $this->generateBotResponse($userText);

        // Simpan respon bot
        $this->chatMessages[] = ['sender' => 'bot', 'text' => $response];
    }

    // Method untuk quick prompt
    public function quickPrompt($text)
    {
        $this->chatMessages[] = ['sender' => 'user', 'text' => $text];
        $this->dispatch('scroll-chat-to-bottom');

        $userText = strtolower($text);
        $response = $this->generateBotResponse($userText);

        $this->chatMessages[] = ['sender' => 'bot', 'text' => $response];
    }

    // Method untuk generate response bot
    private function generateBotResponse($userText)
    {
        if (str_contains($userText, 'jadwal') || str_contains($userText, 'praktik')) {
            if ($this->resolvedDoctorId) {
                $doctor = Doctor::with('user')->find($this->resolvedDoctorId);
                $doctorName = $doctor->user->name ?? 'Dokter Terkait';
                $schedules = DoctorSchedule::where('doctor_id', $this->resolvedDoctorId)->get();

                if ($schedules->isEmpty()) {
                    return "Dokter <b>{$doctorName}</b> belum memiliki jadwal praktik yang terdaftar di sistem saat ini.";
                } else {
                    $response = "Jadwal praktik <b>{$doctorName}</b>:<br>";
                    foreach ($schedules as $sch) {
                        $response .= "• <b>{$sch->day_of_week}</b>: {$sch->start_time} - {$sch->end_time} (Kuota: {$sch->quota})<br>";
                    }
                    return $response;
                }
            } else {
                return "Silakan <b>pilih dokter terlebih dahulu</b> pada formulir di atas, agar saya dapat menampilkan jadwal praktik yang spesifik untuk dokter tersebut.";
            }
        }
        elseif (str_contains($userText, 'biaya') || str_contains($userText, 'harga') || str_contains($userText, 'berobat')) {
            if ($this->resolvedDoctorId) {
                $doctor = Doctor::find($this->resolvedDoctorId);
                $fee = number_format($doctor->consultation_fee ?? 150000, 0, ',', '.');
                return "Biaya konsultasi untuk dokter ini adalah sekitar <b>Rp {$fee}</b>. Biaya dapat berubah tergantung tindakan medis yang diperlukan.";
            } else {
                return "Biaya konsultasi bervariasi tergantung spesialisasi dokter. Silakan pilih dokter di formulir untuk melihat estimasi biaya (umumnya Rp 150.000 - Rp 300.000).";
            }
        }
        elseif (str_contains($userText, 'batal') || str_contains($userText, 'cancel') || str_contains($userText, 'reservasi')) {
            return "Untuk membatalkan reservasi:<br>1. Hubungi administrasi kami melalui WhatsApp<br>2. Atau batalkan melalui menu 'Riwayat Janji Temu' jika Anda sudah login<br><br>Batas pembatalan: minimal 24 jam sebelum jadwal.";
        }
        elseif (str_contains($userText, 'halo') || str_contains($userText, 'hi') || str_contains($userText, 'assalamualaikum')) {
            return "Halo! Ada yang bisa saya bantu? Silakan tanyakan tentang:<br>• Jadwal dokter<br>• Biaya konsultasi<br>• Cara pembatalan";
        }
        else {
            return "Terima kasih atas pesan Anda. Untuk informasi lebih lanjut:<br>• Ketik <b>'jadwal'</b> untuk melihat jadwal dokter<br>• Ketik <b>'biaya'</b> untuk informasi biaya<br>• Ketik <b>'batal'</b> untuk cara pembatalan";
        }
    }

    public function render()
    {
        return view('components.public.booking-wizard')->layout('layouts.app');
    }
}
