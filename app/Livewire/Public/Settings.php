<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Settings extends Component
{
    public string $name = '';
    public string $email = '';
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public bool $showPasswordForm = false;
    public bool $success = false;
    public string $successMessage = '';

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    protected function rules(): array
    {
        return [
            'name'  => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ];
    }

    protected array $messages = [
        'name.required'  => 'Nama tidak boleh kosong',
        'name.min'       => 'Nama minimal 3 karakter',
        'email.required' => 'Email tidak boleh kosong',
        'email.email'    => 'Format email tidak valid',
        'email.unique'   => 'Email sudah digunakan',
    ];

    public function updateProfile()
    {
        $this->validate();

        $user = Auth::user();
        $user->update([
            'name'  => $this->name,
            'email' => $this->email,
        ]);

        $this->success = true;
        $this->successMessage = 'Profil berhasil diperbarui!';

        $this->dispatch('profile-updated');
    }

    public function togglePasswordForm()
    {
        $this->showPasswordForm = !$this->showPasswordForm;
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password'     => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'Password saat ini tidak sesuai');
            return;
        }

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->showPasswordForm = false;
        $this->success = true;
        $this->successMessage = 'Password berhasil diperbarui!';
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    }

    public function render()
    {
        return view('public.settings')->layout('layouts.simple');
    }
}
