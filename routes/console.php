<?php

use App\Models\QaMarker;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function (): void {
    QaMarker::query()->updateOrCreate(['key' => 'scheduler'], ['value' => now()->toIso8601String()]);
})->everyMinute()->name('apps-qa-scheduler-marker')->withoutOverlapping();
