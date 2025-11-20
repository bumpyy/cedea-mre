<?php

// --- TES UNTUK formatPhoneNumber ---
test('formatPhoneNumber formats various inputs to 62 standard', function ($input, $expected) {
    expect(formatPhoneNumber($input))->toBe($expected);
})->with([
    'awalan 0' => ['08123456789', '628123456789'],
    'awalan 8' => ['8123456789', '628123456789'],
    'awalan +62' => ['+628123456789', '628123456789'],
    'awalan 62 (sudah benar)' => ['628123456789', '628123456789'],
    'awalan 0 dengan spasi' => ['0812 345 678', '62812345678'],
    'awalan 0 dengan strip' => ['0812-3456-789', '628123456789'],
    'kotor (campur)' => ['+62 (812) 345-678', '62812345678'],
]);

// --- TES UNTUK isPhone ---

// Dataset 'isPhone' yang valid SEKARANG menyertakan nomor "kotor"
dataset('isPhone_valid_numbers', [
    'clean 08' => '081234567890',
    'clean +62' => '+6281234567890',
    'kotor (spasi)' => '0812 3456 7890',
    'kotor (strip)' => '0812-3456-7890',
    'panjang minimum' => '0812345678',
]);

// Dataset 'isPhone' yang tidak valid
dataset('isPhone_invalid_numbers', [
    'terlalu pendek' => '08123',
    'gak ada 8' => '81234567890123',
    'terlalu panjang' => '081234567890123',
    'awalan salah' => '123456789',
    'huruf' => '0812-abc-def',
]);

test('isPhone returns true for valid phone numbers (including dirty input)', function ($number) {
    expect(isPhone($number))->toBeTrue();
})->with('isPhone_valid_numbers');

test('isPhone returns false for invalid phone numbers', function ($number) {
    expect(isPhone($number))->toBeFalse();
})->with('isPhone_invalid_numbers');

// ... (Tes untuk isEmail juga bisa diletakkan di sini) ...
