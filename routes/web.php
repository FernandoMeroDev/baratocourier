<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Users\Franchisee\Create as UserFranchiseeCreate;
use App\Livewire\Users\Employee\Create as UserEmployeeCreate;
use App\Livewire\Users\Index as UserIndex;
use App\Livewire\Clients\Index as ClientIndex;
use App\Livewire\Clients\Create as ClientCreate;
use App\Livewire\Clients\Edit\Main as ClientEdit;
use App\Livewire\Packages\Create\Main as PackageCreate;
use App\Livewire\Packages\ChooseClient as PackageChooseClient;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', fn () => redirect('/login'))->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'can:users'])->group(function () {
    Route::get('/usuarios', UserIndex::class)->name('users.index');
    Route::get('/usuarios/franquiciado/crear', UserFranchiseeCreate::class)->name('users.franchisee.create')
        ->middleware(['role:administrator']);
    Route::get('/usuarios/empleado/crear', UserEmployeeCreate::class)->name('users.employee.create')
        ->middleware(['role:administrator|franchisee']);
});

Route::middleware(['auth', 'can:clients'])->group(function () {
    Route::get('/clientes', ClientIndex::class)->name('clients.index');
    Route::get('/clientes/crear', ClientCreate::class)->name('clients.create');
    Route::get('/clientes/{client}/editar', ClientEdit::class)->name('clients.edit');
});

Route::middleware(['auth', 'can:packages'])->group(function () {
    Route::get('/paquetes/seleccionar-cliente', PackageChooseClient::class)->name('packages.choose-client');
    Route::get('/paquetes/crear', PackageCreate::class)->name('packages.create');
});
