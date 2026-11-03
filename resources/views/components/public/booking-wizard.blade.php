<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div x-data="{ open: false }" class="fixed bottom-5 right-5 z-50 font-sans">
    <!-- Floating Trigger Button -->
    <button @click="open = !open" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-5 rounded-full shadow-lg flex items-center gap-2 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <span>Tanya Jadwal</span>
    </button>

    <!-- Chat Modal Window -->
    <div x-show="open"
         x-transition
         class="absolute bottom-16 right-0 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden"
         style="display: none;">

        <!-- Top Banner Header -->
        <div class="bg-slate-900 text-white p-4 flex justify-between items-center">
            <div>
                <h4 class="font-bold text-sm">Bot Informasi Dokter</h4>
                <p class="text-xs text-gray-400">Respon Otomatis Sistem</p>
            </div>
            <button @click="open = false" class="text-gray-400 hover:text-white font-bold">&times;</button>
        </div>

        <!-- Chat Bubble Container -->
        <div class="p-4 h-80 overflow-y-auto flex flex-col gap-3 text-sm bg-gray-50">
            @foreach($messages as $msg)
                <div class="flex {{ $msg['sender'] === 'user' ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[85%] p-3 rounded-2xl whitespace-pre-line {{ $msg['sender'] === 'user' ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-800 border border-gray-200 shadow-sm rounded-bl-none' }}">
                        {!! nl2br(e($msg['text'])) !!}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Quick Action Buttons -->
        <div class="p-2 bg-white border-t border-gray-100 flex gap-2 overflow-x-auto text-xs">
            <button wire:click="quickPrompt('jadwal dokter hari ini')" class="whitespace-nowrap bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-full border border-blue-200 font-medium">
                📅 Jadwal Dokter Hari Ini
            </button>
            <button wire:click="quickPrompt('biaya berobat')" class="whitespace-nowrap bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-full font-medium">
                💰 Biaya Berobat
            </button>
        </div>

        <!-- Input Box -->
        <form wire:submit.prevent="sendMessage" class="p-2 bg-white border-t border-gray-200 flex gap-2">
            <input type="text" wire:model="userMessage" placeholder="Ketik 'jadwal dokter'..." class="flex-1 text-sm px-3 py-2 border rounded-xl focus:outline-none focus:ring-1 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-blue-700">Kirim</button>
        </form>
    </div>
</div>
