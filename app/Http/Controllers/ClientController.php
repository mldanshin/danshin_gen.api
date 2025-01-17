<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientStoredRequest;
use App\Repositories\Client;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

final class ClientController extends Controller
{
    public function __construct(
        private readonly Client $repository
    ) { 
    }

    #[OA\Get(
        path: "/api/client/{uid}",
        description: "Клиент.",
        parameters: [
            new OA\Parameter(
                name: "uid",
                description: "Уникальный глобальный идентификатор.",
                in: "path",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    type: "object",
                    ref: "#/components/schemas/clientClientReader"
                )
            ),
            new OA\Response(response: 401, description: 'Требуется авторизация через токен'),
            new OA\Response(
                response: 404,
                description: "Клиент не существует."
            ),
        ]
    )]
    public function show(string $uid): JsonResponse
    {
        return response()->json($this->repository->show($uid));
    }

    public function store(ClientStoredRequest $request): JsonResponse
    {
        return response()->json(
            $this->repository->store($request->getUid())
        );
    }

    #[OA\Delete(
        path: "/api/client/{uid}",
        description: "Удаление клиента.",
        parameters: [
            new OA\Parameter(
                name: "uid",
                description: "Уникальный глобальный идентификатор.",
                in: "path",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK. Пустой json.",
                content: new OA\JsonContent(
                )
            ),
            new OA\Response(response: 401, description: 'Требуется авторизация через токен'),
            new OA\Response(
                response: 404,
                description: "Клиент не существует."
            ),
        ]
    )]
    public function destroy(string $uid): JsonResponse
    {
        $this->repository->delete($uid);
        return response()->json();
    }
}
