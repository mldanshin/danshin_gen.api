<?php

namespace App\Http\Controllers;

use App\Http\Validator;
use App\Http\Requests\Person\MarriagePossibleRequest;
use App\Repositories\MarriageRole;
use App\Repositories\Person\Editor\Marriage;
use App\Repositories\Person\Editor\PersonShort;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

final class MarriageController extends Controller
{
    #[OA\Get(
        path: "/api/marriage/roles"
    )]
    #[OA\Response(
        response: "200",
        description: "Список допустимых ролей в браке или близких отношениях между лицами."
    )]
    public function getRoleAll(MarriageRole $repository): JsonResponse
    {
        return response()->json($repository->getAll());
    }

    #[OA\Get(
        path: "/api/marriage/roles/{gender}",
        parameters: [
            new OA\Parameter(
                name: "gender",
                description: "Id gender.",
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Список допустимых ролей (выборка по полу) в браке 
                    или близких отношениях между лицами."
            ),
            new OA\Response(
                response: "404",
                description: "Id запрошенного пола не найдено."
            )
        ]
    )]
    public function getRoleByGender(MarriageRole $repository, string $gender): JsonResponse
    {
        if (!Validator::requireInteger($gender)) {
            abort(404);
        }

        return response()->json(
            $repository->getByGender($gender)
        );
    }

    #[OA\Get(
        path: "/api/marriage/possible/{personId}",
        parameters: [
            new OA\Parameter(
                name: "person_id",
                description: "Id запрашиваемого лица.",
                required: false,
            ),
            new OA\Parameter(
                name: "birth_date",
                description: "Дата рождения запрашиваемого лица.",
                required: false,
            ),
            new OA\Parameter(
                name: "role_id",
                description: "Id роли для родителя.",
                required: true,
            ),
            new OA\Parameter(
                name: "mariages",
                description: "Массив id лиц, состоящих в отношениях, с запрашиваемым лицом.",
                required: false,
            ),
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Список допустимых лиц для брака или сожительства."
            ),
            new OA\Response(
                response: "422",
                description: "Неверные параметры запроса."
            )
        ]
    )]
    public function getPossible(
        MarriagePossibleRequest $request,
        Marriage $repository,
        PersonShort $repositoryPersonShort
    ): JsonResponse {
        return response()->json(
            $repository->getPossiblePersonShort(
                $request->getPersonId(),
                $request->getBirthDate(),
                $request->getRoleId(),
                $request->getParents(),
                $repositoryPersonShort
            )
        );
    }
}
