<?php

use App\Models\Submission;
use Illuminate\Support\Str;

if (! function_exists('checkPhoneFormat')) {
    /**
     * Check if given phone number is a valid Indonesian phone number.
     *
     * @param  string  $input  Phone number to be checked.
     * @return bool True if the phone number is valid, false otherwise.
     */
    function checkPhoneFormat(string $input): bool
    {
        $phoneRegex = '/^(\+62|62)?[\s-]?0?8[1-9]{1}\d{1}[\s-]?\d{4}[\s-]?\d{2,5}$/';

        return preg_match($phoneRegex, $input);
    }
}

if (! function_exists('checkPhone')) {
    /**
     * Check if a given string is a valid Indonesian phone number.
     *
     * This function checks if the given string is a valid Indonesian phone number.
     * If it is, it returns true. If not, it returns false.
     *
     * @param  string  $input  The string to be checked.
     * @return bool True if the string is a valid Indonesian phone number, false otherwise.
     */
    function isPhone(string $input): bool
    {
        return checkPhoneFormat($input);
    }
}

if (! function_exists('checkEmail')) {

    /**
     * Check if a given string is a valid email address.
     *
     * This function checks if the given string is a valid email address.
     * If it is, it returns true. If not, it returns false.
     *
     * @param  string  $input  The string to be checked.
     * @return bool True if the string is a valid email address, false otherwise.
     */
    function isEmail(string $input): bool
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL);
    }
}

if (! function_exists('formatPhoneNumber')) {
    /**
     * Formats a phone number to the 62... standard.
     * Cleans junk characters and normalizes the prefix.
     *
     * @param  string  $input  The phone number to format.
     * @return string The formatted phone number.
     */
    function formatPhoneNumber(string $input): string
    {
        // 1. Bersihkan karakter non-numerik, kecuali '+' di awal
        $cleaned = preg_replace('/[^0-9+]/', '', $input);

        // 2. Ubah awalan 0 menjadi 62
        // cth: 0812... -> 62812...
        if (str_starts_with($cleaned, '0')) {
            return '62'.substr($cleaned, 1);
        }

        // 3. Ubah awalan +62 menjadi 62
        // cth: +62812... -> 62812...
        if (str_starts_with($cleaned, '+62')) {
            return substr($cleaned, 1);
        }

        // 4. Jika sudah 62 (atau format tidak dikenal), kembalikan apa adanya
        return $cleaned;
    }
}

if (! function_exists('generateUniqueCode')) {
    /**
     * Generates a unique raffle code of a given length.
     * Will keep generating codes until a unique one is found.
     *
     * @param  int  $length  The length of the code to generate.
     * @return string The generated code.
     */
    function generateUniqueCode(string $prefix = 'CEDEA-', int $length = 10, int $second_part = 0): string
    {
        do {
            $code = strtoupper($prefix.Str::random($length).($second_part > 0 ? '-'.Str::random($second_part) : ''));
        } while (Submission::where('raffle_number', $code)->exists());

        return $code;
    }
}
