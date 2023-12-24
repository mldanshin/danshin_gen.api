<?php

namespace App\Http\Controllers;

use App\Http\Requests\People\FilterOrderRequest;
use App\Repositories\People\People;
use App\Repositories\People\FilterOrder\Provider as FilterOrderProvider;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

final class PeopleController extends Controller
{
    public function __construct(
        private readonly People $repository
    ) { 
    }

    #[OA\Get(
        path: "/api/people",
        parameters: [
            new OA\Parameter(
                name: "order",
                description: "Ключевое слово для упорядочивания списка. Доступны: age, name.
                    По умолчанию сортировка по: name",
                required: false,
            ),
            new OA\Parameter(
                name: "search",
                description: "Строка поиска.",
                required: false,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Список всех лиц с кратким описанием."
            ),
            new OA\Response(
                response: "422",
                description: "Неверно указано ключевое слово для упорядочивания списка."
            )
        ]
    )]
    public function getAll(FilterOrderRequest $request, FilterOrderProvider $provider): JsonResponse
    {
        return response()->json(
            $this->repository->getAll(
                $provider->get($request->getPeopleRequest()->orderType),
                $request->getPeopleRequest()->search
            )
        );
    }
}
