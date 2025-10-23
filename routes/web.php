<?php

use App\Http\Controllers\Packages\DownloadController as PackageDownloadController;
use App\Http\Controllers\Shipments\DownloadManifestController as ShipmentManifest;
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
use App\Livewire\Packages\CreateMultiple\Main as PackageCreateMultiple;
use App\Livewire\Packages\ChooseClient as PackageChooseClient;
use App\Livewire\Shipments\Create as ShipmentCreate;
use App\Livewire\Shipments\Index as ShipmentIndex;
use App\Livewire\Shipments\Ship\Main as ShipmentShip;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Livewire\Users\Franchisee\Edit\Main as UserFranchiseeEdit;
use Illuminate\Support\Facades\Storage;

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
    Route::get('/usuarios/franquiciado/{franchisee}/editar', UserFranchiseeEdit::class)->name('users.franchisee.edit')
        ->middleware(['role:administrator']);
    Route::get('/usuarios/franquiciado/logo/{file}', function($file) {
        return Storage::get("users/franchisee/logos/$file");
    })->name('franchisees.logo');
});

Route::middleware(['auth', 'can:clients'])->group(function () {
    Route::get('/clientes', ClientIndex::class)->name('clients.index');
    Route::get('/clientes/crear', ClientCreate::class)->name('clients.create');
    Route::get('/clientes/{client}/editar', ClientEdit::class)->name('clients.edit');
});

Route::middleware(['auth', 'can:packages'])->group(function () {
    Route::get('/paquetes/seleccionar-cliente', PackageChooseClient::class)->name('packages.choose-client');
    Route::get('/paquetes/crear', PackageCreate::class)->name('packages.create');
    Route::get('/paquetes/crear-multiples', PackageCreateMultiple::class)->name('packages.create-multiple');
    Route::get('/paquetes/{package}/descargar', PackageDownloadController::class)->name('packages.download');
});

Route::middleware(['auth', 'can:shipments'])->group(function () {
    Route::get('/embarques', ShipmentIndex::class)->name('shipments.index');
    Route::get('/embarques/crear', ShipmentCreate::class)->name('shipments.create');
    Route::get('/embarques/{shipment}/embarcar', ShipmentShip::class)->name('shipments.ship');
    Route::get('/embarques/{shipment}/manifiesto', ShipmentManifest::class)->name('shipments.manifest');
});
