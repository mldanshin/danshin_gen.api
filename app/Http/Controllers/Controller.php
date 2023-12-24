<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Api Danshin Genealogy",
    version: "1.0.0",
    description: "Доступ ко всем данным только через API токен,
        в противном случае будет возвращаться ошибка 401."
    )]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
