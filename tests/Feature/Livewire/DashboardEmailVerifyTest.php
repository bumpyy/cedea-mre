<?php

use App\Livewire\DashboardEmailVerify;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(DashboardEmailVerify::class)
        ->assertStatus(200);
});
