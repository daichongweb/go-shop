<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IdCardRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(?:\d{15}|\d{17}[\dX])$/', $value)) {
            $fail('身份证号码无效');
        }
    }
}
