<?php

namespace App\Http\Requests;

use App\Rules\ApplyExistsRule;
use App\Rules\IdCardRule;
use App\Rules\MobileRule;
use Illuminate\Validation\Rule;

class SmsLoginRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'mobile' => ['required', new MobileRule()],
            'code' => ['required'],
            'channel_code' => ['numeric']
        ];
    }

    public function messages(): array
    {
        return [
            'channel_code.numeric' => '邀请码错误'
        ];
    }
}
