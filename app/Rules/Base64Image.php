<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64Image implements Rule
{
    public function passes($attribute, $value)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $value)) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'The :attribute must be a valid base64 encoded image.';
    }
}
