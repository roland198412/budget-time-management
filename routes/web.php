<?php

use App\Livewire\Settings\{Appearance, Password, Profile};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // If user is authenticated, redirect to dashboard, otherwise to login
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('home');

Route::get('/dashboard', function () {
    $clients = \App\Models\Client::get();

    return view('dashboard', ['clients' => $clients]);
})->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    #region Clients

    Route::get('clients', \App\Livewire\Clients\Index::class)->name('clients.index');
    Route::get('clients/create', \App\Livewire\Clients\Create::class)->name('clients.create');
    Route::get('clients/edit/{client}', \App\Livewire\Clients\Edit::class)->name('clients.edit');

    #endregion

    #region Client Contact

    Route::get('client-contacts', \App\Livewire\ClientContact\Index::class)->name('client-contacts.index');
    Route::get('client-contacts/create', \App\Livewire\ClientContact\Create::class)->name('client-contacts.create');
    Route::get('client-contacts/edit/{clientContact}', \App\Livewire\ClientContact\Edit::class)->name('client-contacts.edit');

    #endregion

    #region Projects

    Route::get('projects', \App\Livewire\Projects\Index::class)->name('projects.index');
    Route::get('projects/create', \App\Livewire\Projects\Create::class)->name('projects.create');
    Route::get('projects/edit/{project}', \App\Livewire\Projects\Edit::class)->name('projects.edit');

    #endregion

    #region Buckets

    Route::get('buckets', \App\Livewire\Buckets\Index::class)->name('buckets.index');
    Route::get('buckets/create', \App\Livewire\Buckets\Create::class)->name('buckets.create');
    Route::get('buckets/edit/{bucket}', \App\Livewire\Buckets\Edit::class)->name('buckets.edit');

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

    #region NotificationTemplates

    Route::get('notification-templates', \App\Livewire\NotificationTemplates\Index::class)->name('notification-templates.index');
    Route::get('notification-templates/create', \App\Livewire\NotificationTemplates\Create::class)->name('notification-templates.create');
    Route::get('notification-templates/edit/{notificationTemplate}', \App\Livewire\NotificationTemplates\Edit::class)->name('notification-templates.edit');

    #endregion
});

require __DIR__ . '/auth.php';
