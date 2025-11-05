<?php

if (! function_exists('checkPhoneFormat')) {
    /**
     * Check if given phone number is a valid Indonesian phone number.
     *
     * @param  string  $input  Phone number to be checked.
     * @return bool True if the phone number is valid, false otherwise.
     */
    function checkPhoneFormat(string $input): bool
    {
        $phoneRegex = '/8[0-9]{8,12}$/';

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
