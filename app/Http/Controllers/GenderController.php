<?php

namespace App\Http\Controllers;

use App\Repositories\Gender;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

final class GenderController extends Controller
{
    public function __construct(
        private readonly Gender $repository
    ) { 
    }

    #[OA\Get(
        path: "/api/genders"
    )]
    #[OA\Response(
        response: "200",
        description: "Список допустимых полов лица."
    )]
    public function getAll(): JsonResponse
    {
        return response()->json($this->repository->getAll());
    }
}
