<?php

namespace App\Http\Controllers;

use App\Http\Requests\Person\ParentPossibleRequest;
use App\Repositories\ParentRole;
use App\Repositories\Person\Editor\Parents;
use App\Repositories\Person\Editor\PersonShort;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

final class ParentController extends Controller
{
    #[OA\Get(
        path: "/api/parent/roles"
    )]
    #[OA\Response(
        response: "200",
        description: "Список допустимых ролей родителей."
    )]
    public function getRoleAll(ParentRole $repository): JsonResponse
    {
        return response()->json($repository->getAll());
    }

    #[OA\Get(
        path: "/api/parent/possible/{personId}/{roleParent}",
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
                description: "Список допустимых родителей для запрошенного лица."
            ),
            new OA\Response(
                response: "422",
                description: "Неверные параметры запроса."
            )
        ]
    )]
    public function getPossible(
        ParentPossibleRequest $request,
        Parents $repository,
        PersonShort $repositoryPersonShort
    ): JsonResponse {
        return response()->json(
            $repository->getPossiblePersonShort(
                $request->getPersonId(),
                $request->getBirthDate(),
                $request->getRoleId(),
                $request->getMariages(),
                $repositoryPersonShort
            )
        );
    }
}
