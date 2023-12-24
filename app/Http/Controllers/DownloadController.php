<?php

namespace App\Http\Controllers;

use App\Http\Validator;
use App\Http\Requests\Download\PeopleRequest;
use App\Http\Requests\Download\PersonRequest;
use App\Http\Requests\Download\TreeRequest;
use App\Repositories\Download\FileSystem as FileSystem;
use App\Repositories\Download\DataBase\CreatorFile as DataBaseCreatorFile;
use App\Repositories\Download\People\CreatorFile as PeopleCreatorFile;
use App\Repositories\Download\Person\CreatorFile as PersonCreatorFile;
use App\Repositories\Download\Photo\CreatorFile as PhotoCreatorFile;
use App\Repositories\Download\Tree\CreatorFile as TreeCreatorFile;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class DownloadController extends Controller
{
    #[OA\Get(
        path: "/api/download/people",
        parameters: [
            new OA\Parameter(
                name: "type",
                description: "Формат файла. Доступные форматы: pdf.",
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Файл, содержащий всех лиц родословной."
            ),
            new OA\Response(
                response: "302",
                description: "Не указан формат файла в параметрах запроса."
            ),
            new OA\Response(
                response: "404",
                description: "Файл в переданном формате не найден (не поддерживается)."
            ),
        ]
    )]
    public function getPeople(PeopleRequest $request): BinaryFileResponse
    {
        $creator = new PeopleCreatorFile($request->type);
        return response()->download(
            $creator->create(FileSystem::instance()->pathDirectory)
        );
    }

    #[OA\Get(
        path: "/api/download/person/{id}",
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Id запрашиваемого лица.",
                required: true,
            ),
            new OA\Parameter(
                name: "type",
                description: "Формат файла. Доступные форматы: pdf.",
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Файл, содержащий лицо с переданным id."
            ),
            new OA\Response(
                response: "302",
                description: "Не указан формат файла в параметрах запроса."
            ),
            new OA\Response(
                response: "404",
                description: "Лицо с переданным id не найдено или
                    файл в переданном формате не найден (не поддерживается)."
            ),
        ]
    )]
    public function getPerson(string $id, PersonRequest $request): BinaryFileResponse
    {
        if (!Validator::requireInteger($id)) {
            abort(404);
        }

        $creator = new PersonCreatorFile($request->type, (int) $id);
        return response()->download(
            $creator->create(FileSystem::instance()->pathDirectory)
        );
    }

    #[OA\Get(
        path: "/api/download/tree/{id}",
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Id запрашиваемого лица.",
                required: true,
            ),
            new OA\Parameter(
                name: "parent_id",
                description: "Id родителя (запрашиваемого лица) по которому строится древо,
                    по умолчанию древо строится по отцу. Id родителя должно иметь тип integer."
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Файл в формате SVG, содержащий древо лица с переданным id."
            ),
            new OA\Response(
                response: "302",
                description: "Параметры запроса не соответствуют ограничениям."
            ),
            new OA\Response(
                response: "404",
                description: "Лицо с переданным id не найдено
                    или запрошенное лицо не имеет родителя, с переданным parent_id."
            ),
        ]
    )]
    public function getTree(string $id, TreeRequest $request): BinaryFileResponse
    {
        if (!Validator::requireInteger($id)) {
            abort(404);
        }

        $creator = new TreeCreatorFile((int) $id, $request->parent_id);
        return response()->download($creator->create(FileSystem::instance()->pathDirectory));
    }

    #[OA\Get(
        path: "/api/download/db",
        responses: [
            new OA\Response(
                response: "200",
                description: "Файл в формате SQL, содержащий базу данных родословной."
            )
        ]
    )]
    public function getDataBase(): BinaryFileResponse
    {
        $creator = new DataBaseCreatorFile();
        return response()->download(
            $creator->create(FileSystem::instance()->pathDirectory)
        );
    }

    #[OA\Get(
        path: "/api/download/photo",
        responses: [
            new OA\Response(
                response: "200",
                description: "Файл в формате ZIP, содержащий все фотоснимки из родословной."
            ),
            new OA\Response(
                response: "204",
                description: "Фотоснимки на сервере отсутствуют."
            )
        ]
    )]
    public function getPhoto(): BinaryFileResponse|Response
    {
        $creator = new PhotoCreatorFile();
        return response()->download(
            $creator->create(FileSystem::instance()->pathDirectory)
        );
    }
}
