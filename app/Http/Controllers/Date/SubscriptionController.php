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
        parameters: [
            new OA\Parameter(
                name: "personId",
                description: "Id пользователя",
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Url телеграм бота и код."
            ),
            new OA\Response(
                response: "404",
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
        path: "/api/dates/subscription/create/{personId}",
        responses: [
            new OA\Response(
                response: "200",
                description: "Создание подписки."
            ),
            new OA\Response(
                response: "404",
                description: "Пользователя с переданным id не найден."
            ),
        ]
    )]
    public function create(CreatorRequest $request): JsonResponse
    {
        $model = $request->getModel();
        if ($model !== null) {
            $this->repository->create($model);
            return response()->json("OK");
        } else {
            return response()->json(status: 400);
        }
    }

    #[OA\Get(
        path: "/api/dates/subscription/delete/{personId}",
        parameters: [
            new OA\Parameter(
                name: "personId",
                description: "Id пользователя",
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Удаление подписки."
            ),
            new OA\Response(
                response: "404",
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

        return response()->json("OK");
    }

    #[OA\Get(
        path: "/api/dates/subscription/exists/{personId}",
        parameters: [
            new OA\Parameter(
                name: "personId",
                description: "Id пользователя",
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Существование подписки."
            ),
            new OA\Response(
                response: "404",
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
