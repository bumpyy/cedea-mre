<?php

use App\Livewire\UploadForm;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(UploadForm::class)
        ->assertStatus(200);
});

it('can upload a file', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(UploadForm::class)
        ->set('file', __FILE__)
        ->call('upload')
        ->assertHasErrors(['file' => 'required']);
})
    ->skip('wip');
