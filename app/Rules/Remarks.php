<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Remarks implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match("/^([-:)@(a-zA-Z0-9,.' ]+)$/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute only accept a to z, 0 to 9, ), @, (, dash, colon, coma, dot and space.';
    }
}
