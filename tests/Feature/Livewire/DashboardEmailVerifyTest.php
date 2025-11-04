<?php

use App\Livewire\DashboardEmailVerify;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(DashboardEmailVerify::class)
        ->assertStatus(200);
});
