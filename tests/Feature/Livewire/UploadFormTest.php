<?php

use App\Livewire\UploadForm;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(UploadForm::class)
        ->assertStatus(200);
});
