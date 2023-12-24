<?php

namespace App\Http\Controllers;

use App\Http\Validator;
use App\Repositories\Person\Reader\Photo as PhotoRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use OpenApi\Attributes as OA;

final class PhotoController extends Controller
{
    public function __construct(private PhotoRepository $repository)
    {
        
    }

    #[OA\Get(
        path: "/api/person-photo/{person_id}",
        parameters: [
            new OA\Parameter(
                name: "person_id",
                description: "Id лица, чьи фото запрашиваются.",
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Массив фотоснимков для лица."
            ),
            new OA\Response(
                response: "404",
                description: "Лица с переданным id не найдено."
            ),
        ]
    )]
    public function getListByPerson(string $personId): JsonResponse
    {
        if (!Validator::requireInteger($personId)) {
            abort(404);
        }

        return response()->json(
            $this->repository->getListByPerson($personId)
        );
    }

    #[OA\Get(
        path: "/api/photo/{person_id}/{file_name}",
        parameters: [
            new OA\Parameter(
                name: "person_id",
                description: "Id лица, чьё фото запрашивается.",
                required: true,
            ),
            new OA\Parameter(
                name: "file_name",
                description: "Имя файла фото.",
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Файл фотографии."
            ),
            new OA\Response(
                response: "404",
                description: "Фото с переданными параметрами не найдено."
            ),
        ]
    )]
    public function show(string $personId, string $fileName): BinaryFileResponse
    {
        if (!Validator::requireInteger($personId)) {
            abort(404);
        }

        return response()->download(
            $this->repository->getPath((int)$personId, $fileName)
        );
    }
}
