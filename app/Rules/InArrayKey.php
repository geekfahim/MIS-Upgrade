<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InArrayKey implements Rule
{
    private $array;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return array_key_exists($value, $this->array);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The selected :attribute is invalid.';
    }
}
