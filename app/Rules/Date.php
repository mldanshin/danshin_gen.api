<?php

namespace App\Rules;

use Closure;
use App\Models\Date as DateModel;
use Illuminate\Contracts\Validation\ValidationRule;

final class Date implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value !== null && !DateModel::checkText($value)) {
            $fail('validation_app.date.format')->translate(["attribute" => $attribute]);
        }
    }
}