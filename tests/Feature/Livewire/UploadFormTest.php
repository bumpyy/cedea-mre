<?php

use App\Livewire\UploadForm;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(UploadForm::class)
        ->assertStatus(200);
});

it('can upload a file', function () {
    Livewire::test(UploadForm::class)
        ->set('file', __FILE__)
        ->call('upload')
        ->assertHasErrors(['file' => 'required']);
});
