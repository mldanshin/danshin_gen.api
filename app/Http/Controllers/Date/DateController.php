<?php

namespace App\Http\Controllers\Date;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dates\DatesUpcomingRequest;
use App\Repositories\Dates\DatesAll;
use App\Repositories\Dates\DatesUpcoming;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

final class DateController extends Controller
{
    #[OA\Get(
        path: "/api/dates"
    )]
    #[OA\Response(
        response: "200",
        description: "Список всех дат (день рождения и день памяти)."
    )]
    public function getAll(DatesAll $repository): JsonResponse
    {
        return response()->json($repository->get());
    }

    #[OA\Get(
        path: "/api/dates/upcoming",
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
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Список ближайших дат (предыдущие дни, текущий день, будущие дни,
                    в соответтвии с переданными параметрами)."
            )
        ]
    )]
    public function getUpcoming(DatesUpcoming $repository, DatesUpcomingRequest $request): JsonResponse
    {
        return response()->json(
            $repository->get(
                new \DateTime($request->date),
                $request->past_day,
                $request->nearest_day
                )
        );
    }
}
