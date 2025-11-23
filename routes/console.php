<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schedule;
use Spatie\OneTimePasswords\Models\OneTimePassword;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('model:prune', [
    '--model' => [OneTimePassword::class],
])
    ->timezone('Asia/Jakarta')
    ->daily();

Schedule::command('backup:clean')
    ->timezone('Asia/Jakarta')
    ->daily()
    ->at('01:00');

Schedule::command('backup:run')
    ->timezone('Asia/Jakarta')
    ->daily()
    ->at('01:30');

Schedule::call(function () {
    $storagePath = config('error-mailer.storage_path');
    $files = File::files($storagePath);

    foreach ($files as $file) {
        if ($file->getMTime() < now()->subMonths(3)->timestamp) {
            File::delete($file->getRealPath());
        }
    }
})->daily();

Schedule::command('queue:work --stop-when-empty')
    ->everyFourMinutes()
    ->withoutOverlapping(10);
