<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasDateTimeFormatter;

    protected function description(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value,
            set: fn($value) => $value ?: '',
        );
    }
}
