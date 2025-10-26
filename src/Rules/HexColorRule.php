<?php

namespace MightyWeb\Rules;

use Illuminate\Contracts\Validation\Rule;

class HexColorRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^#[A-Fa-f0-9]{6}$/', $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid hex color code (e.g., #3B82F6).';
    }
}
