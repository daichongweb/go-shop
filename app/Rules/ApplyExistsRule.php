<?php

namespace App\Rules;

use App\Models\VipApply;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ApplyExistsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (VipApply::query()->where('mobile', $value)->whereIn('status', [1, 0])->exists()) {
            $fail('申请已存在');
        }
    }
}
