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

    #region ClockifyUser

    Route::get('clockify-users', \App\Livewire\ClockifyUsers\Index::class)->name('clockify-users.index');
    Route::get('clockify-users/edit/{clockifyUser}', \App\Livewire\ClockifyUsers\Edit::class)->name('clockify-users.edit');

    #endregion

    #region TimeEntries

    Route::get('time-entries', \App\Livewire\TimeEntries\Index::class)->name('time-entries.index');

    #endregion

    #region ClockifyUserPayments

    Route::get('clockify-user-payments', \App\Livewire\ClockifyUserPayments\Index::class)->name('clockify-user-payments.index');
    Route::get('clockify-user-payments/create', \App\Livewire\ClockifyUserPayments\Create::class)->name('clockify-user-payments.create');
    Route::get('clockify-user-payments/edit/{payment}', \App\Livewire\ClockifyUserPayments\Edit::class)->name('clockify-user-payments.edit');

    #endregion
});

require __DIR__ . '/auth.php';
