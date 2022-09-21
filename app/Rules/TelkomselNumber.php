<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TelkomselNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (substr($value, 0, 4) == '0811' || substr($value, 0, 4) == '0812' || substr($value, 0, 4) == '0813' || substr($value, 0, 4) == '0821' || substr($value, 0, 4) == '0822' || substr($value, 0, 4) == '0851' || substr($value, 0, 4) == '0852' || substr($value, 0, 4) == '0853') {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format Nomor Telepon Salah / Bukan Nomor Telkomsel';
    }
}
