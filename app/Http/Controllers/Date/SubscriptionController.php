<?php

namespace App\Http\Controllers\Date;

use App\Http\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dates\Subscription\CreatorRequest;
use App\Repositories\Dates\Subscription\Contract as Repository;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

final class SubscriptionController extends Controller
{
    public function __construct(private Repository $repository)
    {
    }

    #[OA\Get(
        path: "/api/dates/subscription/data/{personId}",
        description: "Url телеграм бота и код.",
        parameters: [
            new OA\Parameter(
                name: "personId",
                description: "Id пользователя",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "string",
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    type: "object",
                    ref: "#/components/schemas/datesSubscriptionData"
                )
            ),
            new OA\Response(response: 401, description: 'Требуется авторизация через токен'),
            new OA\Response(
                response: 404,
                description: "Пользователя с переданным id не найден."
            ),
        ]
    )]
    public function getData(string $personId): JsonResponse
    {
        if (!Validator::requireInteger($personId)) {
            abort(404);
        }

        return response()->json(
            $this->repository->getData($personId)
        );
    }

    #[OA\Get(
        path: "/api/dates/subscription/create",
        description: "Создание подписки.",
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                type: "object",
                ref: "#/components/schemas/datesSubscriptionCreator"
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "OK. Пустой json.",
                content: new OA\JsonContent(
                )
            ),
            new OA\Response(
                response: 404,
                description: "Пользователь не найден (в данных от телеграм)."
            ),
            new OA\Response(response: 422, description: "Неверные параметры запроса."),
        ]
    )]
    public function create(CreatorRequest $request): JsonResponse
    {
        $model = $request->getModel();
        if ($model !== null) {
            $this->repository->create($model);
            return response()->json();
        } else {
            return response()->json(status: 422);
        }
    }

    #[OA\Get(
        path: "/api/dates/subscription/delete/{personId}",
        description: "Удаление подписки.",
        parameters: [
            new OA\Parameter(
                name: "personId",
                description: "Id пользователя",
                in: "query",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK. Пустой json."
            ),
            new OA\Response(response: 401, description: 'Требуется авторизация через токен'),
            new OA\Response(
                response: 404,
                description: "Пользователя с переданным id не найден."
            ),
        ]
    )]
    public function delete(string $personId): JsonResponse
    {
        if (!Validator::requireInteger($personId)) {
            abort(404);
        }

        $this->repository->delete($personId);

        return response()->json();
    }

    #[OA\Get(
        path: "/api/dates/subscription/exists/{personId}",
        description: "Проверка существования подписки.",
        parameters: [
            new OA\Parameter(
                name: "personId",
                description: "Id пользователя",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    type: "object",
                    ref: "#/components/schemas/datesSubscriptionExist"
                )
            ),
            new OA\Response(response: 401, description: 'Требуется авторизация через токен'),
            new OA\Response(
                response: 404,
                description: "Пользователь с переданным id не найден."
            ),
        ]
    )]
    public function exists(string $personId): JsonResponse
    {
        if (!Validator::requireInteger($personId)) {
            abort(404);
        }

        return response()->json(
            $this->repository->exists($personId)
        );
    }
}
