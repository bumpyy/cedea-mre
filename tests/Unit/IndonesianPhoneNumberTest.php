<?php

// PENTING: Dibutuhkan untuk Validator Facade
uses(Tests\TestCase::class);

use App\Rules\IndonesianPhoneNumber;
use Illuminate\Support\Facades\Validator;

// Kita 'instantiate' rule-nya
$rule = [new IndonesianPhoneNumber];

// Dataset ini sekarang HARUS menyertakan input "kotor" sebagai input yang VALID
dataset('rule_valid_phones', [
    'clean 08' => '082312364932',
    'clean +62' => '+6282312364932',
    'panjang minimum' => '082312364932',
    'kotor (spasi)' => '0823 1236 4932',
    'kotor (strip)' => '0823-1236-4932',
]);

// Dataset ini untuk yang benar-benar tidak valid
dataset('rule_invalid_phones', [
    'terlalu pendek' => '08123',
    'terlalu panjang' => '081234567890123',
    'awalan salah' => '123456789',
    'huruf' => '0812-abc-def',
]);

test('valid indonesian phone numbers pass validation (including dirty input)', function ($number) use ($rule) {
    $validator = Validator::make(['phone' => $number], [
        'phone' => $rule,
    ]);

    // Kita HARAPKAN lolos, karena rule akan membersihkannya
    expect($validator->passes())->toBeTrue();
})->with('rule_valid_phones');

test('invalid indonesian phone numbers fail validation', function ($number) use ($rule) {
    $validator = Validator::make(['phone' => $number], [
        'phone' => $rule,
    ]);

    // Kita HARAPKAN gagal
    expect($validator->fails())->toBeTrue();
})->with('rule_invalid_phones');
