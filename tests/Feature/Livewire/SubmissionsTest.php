<?php

use App\Livewire\Submissions;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Submissions::class)
        ->assertStatus(200);
});
