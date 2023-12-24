<?php

namespace App\Exceptions;

use App\Models\Person\Editor\Error as ErrorModel;
use Illuminate\Support\Collection;
use Exception;

final class InvalidInputException extends Exception
{
    /**
     * @param Collection<int, ErrorModel> $errors
     */
    public function __construct(public Collection $errors)
    {

    }
}
