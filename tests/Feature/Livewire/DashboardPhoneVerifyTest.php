<?php

use App\Livewire\DashboardPhoneVerify;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(DashboardPhoneVerify::class)
        ->assertStatus(200);
});
