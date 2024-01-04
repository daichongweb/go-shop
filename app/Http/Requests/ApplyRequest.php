<?php

namespace App\Http\Requests;

use App\Rules\ApplyExistsRule;
use App\Rules\IdCardRule;
use App\Rules\MobileRule;
use Illuminate\Validation\Rule;

class ApplyRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:18|max:2',
            'mobile' => ['required', new MobileRule(), new ApplyExistsRule()],
            'id_card' => ['required', new IdCardRule()],
            'type' => [
                'required', Rule::in([1, 2]),
            ],
            'remark' => 'max:128',
        ];
    }
}
