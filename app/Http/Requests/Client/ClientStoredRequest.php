<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\Request;

final class ClientStoredRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "uid" => "required|string"
        ];
    }

    public function getUid(): string
    {
        return $this->input("uid");
    }
}
