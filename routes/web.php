<?php

use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\UserManagement\UserIndex;
use App\Livewire\TicketManagement\Addticket;
use App\Livewire\Cashier\AddTicketnumberRange;
use App\Livewire\Enforcer\RequestTicketNumber;
use App\Livewire\TicketManagement\AddViolation;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('/add_violations', AddViolation::class)->name('violations')->middleware(['auth']);
    Route::get('/users', UserIndex::class)->name('userManagement');
    Route::get('/casher_assign_ticketnumber', AddTicketnumberRange::class)->name('AssignTicketNumber');
    Route::get('/request_ticketnumber', RequestTicketNumber::class)->name('RequestTicketNumber');
    Route::get('/addticket', Addticket::class)->name('addticket');
});

require __DIR__ . '/auth.php';
