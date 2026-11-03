<?php

namespace App\Livewire\Public;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Appointment;
use Livewire\Component;
use Illuminate\Support\Str;

class BookingWizard extends Component
{
    public $selectedDoctor = null;
    public $selectedDate = '';
    public $selectedTime = '';
    public $complaint = '';

    public $doctors = [];
    public $availableSchedules = [];

    public function mount()
    {
        $this->doctors = Doctor::with('user')->get();
    }

    public function updatedSelectedDoctor($doctorId)
    {
        $this->availableSchedules = DoctorSchedule::where('doctor_id', $doctorId)->get();
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
            'patient_id'       => auth()->user()?->patient?->id ?? Doctor::first()->id, // Diperbaiki: auth()->user()
            'doctor_id'        => $this->selectedDoctor,
            'appointment_date' => $this->selectedDate,
            'appointment_time' => $this->selectedTime,
            'booking_source'   => 'web',
            'status'           => 'pending',
            'complaint'        => $this->complaint,
        ]);

        session()->flash('message', 'Janji temu berhasil dibuat! Kode Booking Anda: ' . $appointment->appointment_code);
        $this->reset(['selectedDoctor', 'selectedDate', 'selectedTime', 'complaint']);
    }

    public function render()
    {
        // Diperbaiki: Mengarahkan ke komponen Blade di folder resources/views/components/public/
        return view('components.public.booking-wizard');
    }
}
