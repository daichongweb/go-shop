<?php

namespace App\Http\Requests;

use App\Rules\ApplyExistsRule;
use App\Rules\IdCardRule;
use App\Rules\MobileRule;
use Illuminate\Validation\Rule;

class SmsCodeRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'mobile' => ['required', new MobileRule()],
        ];
    }
}
