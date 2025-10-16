<?php

use App\Livewire\Auth\Register;
use Livewire\Livewire;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('address', 'test address')
        ->set('phone', 'test phone')
        ->set('accept_terms', true)
        ->set('password_confirmation', 'password')
        ->call('register');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('new users cannot register if term not accepted', function () {
    $response = Livewire::test(Register::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('address', 'test address')
        ->set('phone', 'test phone')
        ->set('accept_terms', false)
        ->set('password_confirmation', 'password')
        ->call('register');

    $response
        ->assertHasErrors(['accept_terms']);

    $this->assertGuest();

});
