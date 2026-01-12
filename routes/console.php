<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


\Illuminate\Support\Facades\Schedule::command('clockify:populate-detailed-report')->everyFifteenMinutes();

\Illuminate\Support\Facades\Schedule::command('app:send-time-sheet --weekly --bucket --lastweek')->mondays()->at('07:00');