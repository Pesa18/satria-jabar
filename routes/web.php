<?php

use App\Http\Controllers\FormHalal;
use App\Http\Controllers\FormKiblat;
use App\Http\Controllers\FormMasjid;
use Filament\Schemas\Components\Form;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
//     Volt::route('settings/password', 'settings.password')->name('settings.password');
//     Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
// });

Route::prefix('layanan')->group(function () {
    Route::get('halal', [FormHalal::class, 'index'])->name('layanan.halal');
    Route::get('idmasjid', [FormMasjid::class, 'index'])->name('layanan.masjid');
    Route::get('arahkiblat', [FormKiblat::class, 'index'])->name('layanan.kiblat');
});

require __DIR__ . '/auth.php';
