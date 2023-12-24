<?php

namespace App\Http\Controllers\Date;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dates\NotificationRequest;
use App\Services\Dates\Events as Service;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

final class NotificationController extends Controller
{
    public function __construct(private Service $service)
    {
    }

    #[OA\Get(
        path: "/api/dates/notify-all",
        description: "Отправление информации о ближайших датах (день рождения, день памяти).",
        parameters: [
            new OA\Parameter(
                name: "date",
                description: "Текущее число в формате гггг-мм-дд",
                in: "query",
                required: true,
                schema: new OA\Schema(
                    type: "string",
                    format: "date"
                )
            ),
            new OA\Parameter(
                name: "past_day",
                description: "Количество предшествующих дней (число от 1 до 30).",
                in: "query",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                )
            ),
            new OA\Parameter(
                name: "nearest_day",
                description: "Количество будующих дней (число от 1 до 30).",
                in: "query",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                )
            ),
            new OA\Parameter(
                name: "path_person",
                description: "Путь к лицу.",
                in: "query",
                required: true,
                schema: new OA\Schema(
                    type: "string",
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK. Пустой Json.",
                content: new OA\JsonContent(
                )
            ),
            new OA\Response(response: 401, description: 'Требуется авторизация через токен'),
            new OA\Response(
                response: 500,
                description: "Ошибка на сервере, информация не отправлена. Пустой Json.",
                content: new OA\JsonContent(
                )
            ),
        ]
    )]
    public function notifyAll(NotificationRequest $request): JsonResponse
    {
        $res = $this->service->send(
            new \DateTime($request->date),
            $request->past_day,
            $request->nearest_day,
            $request->path_person
        );

        if ($res === true) {
            return response()->json("OK");
        } else {
            return response()->json(status: 500);
        }
    }
}
