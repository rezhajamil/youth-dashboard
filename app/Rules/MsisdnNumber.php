<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MsisdnNumber implements Rule
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
        if (substr($value, 0, 5) == '62811' || substr($value, 0, 5) == '62812' || substr($value, 0, 5) == '62813' || substr($value, 0, 5) == '62821' || substr($value, 0, 5) == '62822' || substr($value, 0, 5) == '62823' || substr($value, 0, 5) == '62851' || substr($value, 0, 5) == '62852' || substr($value, 0, 5) == '62853') {
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
        return 'Format MSISDN Salah / Bukan nomor TSEL. Awalan harus 628xxxx';
    }
}
