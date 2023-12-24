<?php

namespace App\Http\Controllers;

use App\Http\Validator;
use App\Http\Requests\Tree\InteractiveRequest;
use App\Http\Requests\Tree\TreeRequest;
use App\Repositories\Tree\Tree as TreeRepository;
use App\View\Tree\Tree as TreeView;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use OpenApi\Attributes as OA;

final class TreeController extends Controller
{
    #[OA\Get(
        path: "/api/tree/model/{id}",
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Id запрашиваемого лица",
                required: true,
            ),
            new OA\Parameter(
                name: "parent_id",
                description: "Id родителя (запрашиваемого лица) по которому строится древо,
                    по умолчанию древо строится случайным образом по отцу или матери.",
                required: false,
            )
        ]
    )]
    #[OA\Response(
        response: "200",
        description: "Модель древа запрашиваемого лица в формате JSON."
    )]
    public function getModel(string $id, TreeRequest $request, TreeRepository $repository): JsonResponse
    {
        if (!Validator::requireInteger($id)) {
            abort(404);
        }

        $model = $repository->get((int) $id, $request->getParentId());
        return response()->json($model);
    }

    #[OA\Get(
        path: "/api/tree/image/{id}",
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Id запрашиваемого лица",
                required: true,
            ),
            new OA\Parameter(
                name: "parent_id",
                description: "Id родителя (запрашиваемого лица) по которому строится древо,
                    по умолчанию древо строится случайным образом по отцу или матери.",
                required: false,
            )
        ]
    )]
    #[OA\Response(
        response: "200",
        description: "Файл изображения, содержащий древо запрашиваемого лица."
    )]
    public function getImage(string $id, TreeRequest $request, TreeRepository $repository): View
    {
        if (!Validator::requireInteger($id)) {
            abort(404);
        }

        $model = $repository->get((int) $id, $request->getParentId());
        return (new TreeView($model, null))->view;
    }

    #[OA\Get(
        path: "/api/tree/image-interactive/{id}",
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Id запрашиваемого лица",
                required: true,
            ),
            new OA\Parameter(
                name: "parent_id",
                description: "Id родителя (запрашиваемого лица) по которому строится древо,
                    по умолчанию древо строится случайным образом по отцу или матери.",
                required: false,
            ),
            new OA\Parameter(
                name: "path_person",
                description: "Путь к лицу.",
                required: true,
            ),
            new OA\Parameter(
                name: "path_tree",
                description: "Путь к древу лица.",
                required: true,
            ),
            new OA\Parameter(
                name: "image_person",
                description: "Путь к изображению, используемому в ссылке.",
                required: true,
            ),
            new OA\Parameter(
                name: "image_tree",
                description: "Путь к изображению, используемому в ссылке.",
                required: true,
            )
        ]
    )]
    #[OA\Response(
        response: "200",
        description: "Файл изображения, содержащий древо запрашиваемого лица,
            содержащий интерактивные ссылки в древе.
            Ссылка на лицо должна соответствовать шаблону path/person_id,
            где path - путь к древу,
            person_id - id номер запрашиваемого лица,
            то есть Вы предоставляете path, к которому настоящее API добавляет id лица.
            Ссылка на древо лица должна соответствовать шаблону path/person_id.
            Также Вы должны предоставить путь к двум изображениям, которые будут использоваться в ссылке."
    )]
    public function getImageInteractive(
        string $id,
        InteractiveRequest $request,
        TreeRepository $repository
    ): View {
        if (!Validator::requireInteger($id)) {
            abort(404);
        }

        $model = $repository->get((int) $id, $request->getParentId());
        return (new TreeView($model, $request->getModel()))->view;
    }

    #[OA\Get(
        path: "/api/tree/toggle/{id}",
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Id запрашиваемого лица",
                required: true,
            ),
            new OA\Parameter(
                name: "parent_id",
                description: "Id родителя (запрашиваемого лица) по которому строится древо,
                    по умолчанию древо строится случайным образом по отцу или матери.
                    Id родителя должно иметь тип integer.",
                required: false,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Переключатель для древа запрашиваемого лица."
            ),
            new OA\Response(
                response: "204",
                description: "Переключатель для запрашиваемого лица отсутствует,
                    так как лицо не имеет родителей."
            ),
            new OA\Response(
                response: "404",
                description: "Лицо с запрошенным id не существует
                    или запрошенное лицо не имеет родителя, с переданным parent_id."
            ),
            new OA\Response(
                response: "422",
                description: "Параметры запроса не соответствуют ограничениям."
            )
        ]
    )]
    public function getToggle(string $id, TreeRequest $request, TreeRepository $repository): JsonResponse
    {
        if (!Validator::requireInteger($id)) {
            abort(404);
        }

        return response()->json(
            $repository->getToggle((int) $id, $request->getParentId())
        );
    }
}
