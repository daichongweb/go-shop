<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class BaseRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * @throws ApiException
     */
    protected function failedValidation($validator)
    {
        throw new ApiException($validator->errors()->first());
    }
}
