<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;
use Spatie\OneTimePasswords\Models\OneTimePassword;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('model:prune', [
    '--model' => [OneTimePassword::class],
])->daily();

Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');

Schedule::call(function () {
    $storagePath = config('error-mailer.storage_path');
    $files = File::files($storagePath);

    foreach ($files as $file) {
        if ($file->getMTime() < now()->subMonths(3)->timestamp) {
            File::delete($file->getRealPath());
        }
    }

    Log::info('this is from scheduler');
})->daily();

Schedule::command('queue:work --stop-when-empty')
    ->everyMinute()
    ->withoutOverlapping();
