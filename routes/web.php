<?php

use App\Livewire\Settings\{Appearance, Password, Profile};
use Illuminate\Support\Facades\Route;

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

    #region Clients

    Route::get('clients', \App\Livewire\Clients\Index::class)->name('clients.index');
    Route::get('clients/create', \App\Livewire\Clients\Create::class)->name('clients.create');
    Route::get('clients/edit/{client}', \App\Livewire\Clients\Edit::class)->name('clients.edit');

    #endregion

    #region Projects

    Route::get('projects', \App\Livewire\Projects\Index::class)->name('projects.index');
    Route::get('projects/create', \App\Livewire\Projects\Create::class)->name('projects.create');
    Route::get('projects/edit/{project}', \App\Livewire\Projects\Edit::class)->name('projects.edit');

    #endregion
});

require __DIR__ . '/auth.php';
