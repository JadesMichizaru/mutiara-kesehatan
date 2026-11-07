<?php

use App\Livewire\Public\ClinicLanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama / Landing Page
Route::get('/', ClinicLanding::class)->name('index');

// Halaman Form Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

// Halaman Form Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

/*
|--------------------------------------------------------------------------
| POST Routes (Proses Pendaftaran, Login, & Booking)
|--------------------------------------------------------------------------
*/

// 1. Proses Register Pasien Baru
Route::post('/register', function (Request $request) {
    $request->validate([
        'name'         => 'required|string|max:255',
        'email'        => 'required|string|email|max:255|unique:users',
        'phone_number' => 'required|string|max:20|unique:users',
        'password'     => 'required|string|min:8|confirmed',
    ]);

    // Buat User Pasien Baru
    $user = User::create([
        'name'         => $request->name,
        'email'        => $request->email,
        'phone_number' => $request->phone_number,
        'password'     => Hash::make($request->password),
        'roles'        => 'pasien',
        'is_active'    => true,
    ]);

    // Buat Profil Pasien Kosong Terlebih Dahulu (Relasi 1:1)
    Patient::create([
        'user_id'       => $user->id,
        'nik'           => 'NIK-' . strtoupper(Str::random(10)), // Placeholder NIK sementara
        'gender'        => 'Laki-Laki',
        'date_of_birth' => now()->subYears(20)->toDateString(),
        'address'       => 'Belum Diisi',
    ]);

    // Auto Login Setelah Register
    Auth::login($user);

    return redirect()->route('index')->with('success', 'Pendaftaran akun pasien berhasil!');
});

// 2. Proses Authenticate Login
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/')->with('success', 'Selamat datang kembali!');
    }

    return back()->withErrors([
        'email' => 'Email atau kata sandi yang Anda masukkan salah.',
    ])->onlyInput('email');
});

// 3. Proses Submit Booking / Janji Temu Pasien
Route::post('/appointments', function (Request $request) {
    $request->validate([
        'patient_name'     => 'required|string|max:255',
        'patient_email'    => 'required|email',
        'patient_phone'    => 'required|string',
        'appointment_date' => 'required|date|after_or_equal:today',
        'service_select'   => 'required|string',
        'doctor_id'        => 'nullable|exists:doctors,id',
        'patient_notes'    => 'nullable|string|max:500',
    ]);

    $code = 'APT-' . strtoupper(Str::random(6));

    Appointment::create([
        'appointment_code' => $code,
        'patient_id'       => Auth::user()?->patient?->id, // Null jika Guest
        'doctor_id'        => $request->doctor_id,
        'appointment_date' => $request->appointment_date,
        'appointment_time' => '09:00:00',
        'booking_source'   => 'web',
        'status'           => 'pending',
        'complaint'        => "Poli: {$request->service_select}. Catatan: {$request->patient_notes}",
    ]);

    return back()->with('success', "Janji temu berhasil dibuat! Kode Booking Anda: {$code}");
})->name('appointments.store');

/*
|--------------------------------------------------------------------------
| PUT / PATCH Routes (Update Profil & Ubah Status Janji Temu)
|--------------------------------------------------------------------------
*/

// 1. Update Profil Pasien (Memanfaatkan HTML Form Method Spoofing: @method('PUT'))
Route::put('/profile/update', function (Request $request) {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    $request->validate([
        'name'         => 'required|string|max:255',
        'phone_number' => 'required|string|max:20|unique:users,phone_number,' . $user->id,
        'address'      => 'nullable|string|max:500',
    ]);

    $user->update([
        'name'         => $request->name,
        'phone_number' => $request->phone_number,
    ]);

    if ($user->patient) {
        $user->patient->update([
            'address' => $request->address,
        ]);
    }

    return back()->with('success', 'Profil berhasil diperbarui!');
})->middleware('auth')->name('profile.update');

// 2. Batalkan / Reschedule Janji Temu Pasien
Route::put('/appointments/{id}/cancel', function ($id) {
    $appointment = Appointment::findOrFail($id);

    $appointment->update([
        'status' => 'cancelled',
    ]);

    return back()->with('success', 'Jadwal konsultasi berhasil dibatalkan.');
})->middleware('auth')->name('appointments.cancel');

/*
|--------------------------------------------------------------------------
| DELETE Routes (Proses Logout & Hapus Janji Temu)
|--------------------------------------------------------------------------
*/

// 1. Proses Logout User
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('success', 'Anda telah berhasil keluar.');
})->name('logout');

// 2. Hapus Data Janji Temu (Method Spoofing: @method('DELETE'))
Route::delete('/appointments/{id}', function ($id) {
    $appointment = Appointment::findOrFail($id);
    $appointment->delete();

    return back()->with('success', 'Data janji temu berhasil dihapus.');
})->middleware('auth')->name('appointments.destroy');
