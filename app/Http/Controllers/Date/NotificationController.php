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
        parameters: [
            new OA\Parameter(
                name: "date",
                description: "Текущее число в формате гггг-мм-дд",
                required: true,
            ),
            new OA\Parameter(
                name: "past_day",
                description: "Количество предшествующих дней (число от 1 до 30).",
                required: true,
            ),
            new OA\Parameter(
                name: "nearest_day",
                description: "Количество будующих дней (число от 1 до 30).",
                required: true,
            ),
            new OA\Parameter(
                name: "path_person",
                description: "Путь к лицу.",
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Уведомления о ближайших датах направлено."
            ),
            new OA\Response(
                response: "500",
                description: "Ошибки при отправлении уведомлений."
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
