<?php

namespace App\Rules;

use Closure;
use App\Models\Date as DateModel;
use App\Models\DateTimeCustom as DateTimeCustomModel;
use Illuminate\Contracts\Validation\ValidationRule;

final class BirthDate implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value !== null) {
            if (DateModel::checkText($value)) {
                $date = DateModel::decode($value);
                $dateCurrent = new DateTimeCustomModel();

                if (!$date->hasUnknown) {
                    if ($date->string > $dateCurrent->format("Y-m-d")) {
                        $fail('validation_app.birth_date.future')->translate();
                    }
                }
            } else {
                $fail('validation_app.date.format')->translate(["attribute" => $attribute]);
            }
        }
    }
}