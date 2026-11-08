<?php
namespace App\Livewire\Public;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Appointment;
use Livewire\Component;
use Illuminate\Support\Str;

class ClinicLanding extends Component
{
    // Form Input States
    public string $patientName = '';
    public string $patientEmail = '';
    public string $patientPhone = '';
    public string $appointmentDate = '';
    public string $serviceSelect = '';
    public ?string $selectedDoctor = null;
    public string $patientNotes = '';

    // Success State
    public bool $isSuccess = false;
    public string $bookingCode = '';

    // Data Collections
    public $doctors = [];
    public $schedules = [];

    // Chatbot Internal States
    public array $chatMessages = [];
    public string $userMessage = '';

    protected function rules(): array
    {
        return [
            'patientName'     => 'required|min:3',
            'patientEmail'    => 'required|email',
            'patientPhone'    => [
                'required',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/'
            ],
            'appointmentDate' => 'required|date|after_or_equal:today',
            'serviceSelect'   => 'required',
            'selectedDoctor'  => 'nullable',
            'patientNotes'    => 'nullable|string|max:500',
        ];
    }

    protected array $messages = [
        'patientName.required'     => 'Nama minimal 3 karakter',
        'patientEmail.required'    => 'Format email tidak valid',
        'patientPhone.required'    => 'Masukkan nomor WhatsApp yang valid',
        'patientPhone.regex'       => 'Format nomor telepon tidak valid. Gunakan: 08xxxxxxxxxx',
        'appointmentDate.required' => 'Pilih tanggal kunjungan',
        'serviceSelect.required'   => 'Pilih layanan yang diinginkan',
    ];

    public function mount()
    {
        // Ambil data dokter asli jika ada di DB, jika tidak buat data dummy dari HTML
        $this->doctors = Doctor::with('user')->get();

        // Chatbot Default Welcome Message
        $this->chatMessages[] = [
            'sender' => 'bot',
            'text'   => 'Halo! 👋 Saya <strong>SehatBot</strong>, asisten virtual Klinik SehatSejahtera.<br><br>Saya siap membantu Anda mengenai jadwal dokter, biaya, atau info pendaftaran!',
            'time'   => now()->format('H:i')
        ];
    }

    public function submitAppointment()
    {
        $this->validate();

        $code = 'APT-' . strtoupper(Str::random(6));

        // Jika user / patient terautentikasi atau buat janji umum
        Appointment::create([
            'appointment_code' => $code,
            'patient_id'       => auth()->users()?->patient?->id ?? null,
            'doctor_id'        => $this->selectedDoctor,
            'appointment_date' => $this->appointmentDate,
            'appointment_time' => '09:00', // waktu default / disesuaikan
            'booking_source'   => 'web',
            'status'           => 'pending',
            'complaint'        => "Poli: {$this->serviceSelect}. Catatan: {$this->patientNotes}",
        ]);

        $this->bookingCode = $code;
        $this->isSuccess = true;
        $this->reset(['patientName', 'patientEmail', 'patientPhone', 'appointmentDate', 'serviceSelect', 'selectedDoctor', 'patientNotes']);
    }

    // Interactive Logic Chatbot Auto-Reply
    public function sendChatMessage()
    {
        if (trim($this->userMessage) === '') return;

        $text = $this->userMessage;

        $this->chatMessages[] = [
            'sender' => 'user',
            'text'   => e($text),
            'time'   => now()->format('H:i')
        ];

        $input = strtolower($text);
        $this->userMessage = '';

        $reply = $this->generateBotReply($input);

        $this->chatMessages[] = [
            'sender' => 'bot',
            'text'   => $reply,
            'time'   => now()->format('H:i')
        ];
    }

    public function quickReply(string $query)
    {
        $this->userMessage = $query;
        $this->sendChatMessage();
    }

    private function generateBotReply(string $input): string
    {
        if (str_contains($input, 'jam') || str_contains($input, 'buka') || str_contains($input, 'operasional')) {
            return "🕐 <strong>Jam Operasional Klinik:</strong><br>• Senin - Jumat: 08:00 - 21:00 WIB<br>• Sabtu: 08:00 - 17:00 WIB<br>• Minggu: 09:00 - 14:00 WIB<br>🚑 <strong>IGD:</strong> 24 Jam";
        } elseif (str_contains($input, 'jadwal') || str_contains($input, 'dokter')) {
            // Query langsung ke PostgreSQL Doctor Schedule
            $today = now()->isoFormat('dddd');
            $schedule = DoctorSchedule::with('doctor.user')->where('day_of_week', $today)->get();

            if ($schedule->isEmpty()) {
                return "👨‍⚕️ <strong>Dokter Praktik Hari Ini ({$today}):</strong><br>• dr. Ahmad Fauzi, Sp.PD (08:00 - 14:00)<br>• dr. Siti Nurhaliza, Sp.A (09:00 - 15:00)";
            }

            $text = "👨‍⚕️ <strong>Dokter Praktik Aktif Hari Ini:</strong><br>";
            foreach ($schedule as $sch) {
                $text .= "• " . $sch->doctor->user->name . " (" . $sch->doctor->specialization . ") [" . substr($sch->start_time,0,5) . " - " . substr($sch->end_time,0,5) . "]<br>";
            }
            return $text;
        } elseif (str_contains($input, 'biaya') || str_contains($input, 'tarif')) {
            return "💰 <strong>Estimasi Biaya:</strong><br>• Dokter Umum: Rp 100k - 150k<br>• Spesialis: Rp 200k - 350k<br>• Laboratorium: Rp 150k+<br>✅ Menerima BPJS & Asuransi Swasta.";
        }

        return "Terima kasih! Anda dapat melakukan booking konsultasi langsung pada form di halaman ini atau hubungi (021) 123-4567.";
    }

    public function render()
    {
        return view('components.public.clinic-landing');
    }
}
