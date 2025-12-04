<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IndonesianPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Validasi format nomor telepon Indonesia
        if (! checkPhoneFormat($value)) {
            $fail('Format nomor telepon tidak valid.');
        }
    }
}
