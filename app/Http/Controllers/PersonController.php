<?php

namespace App\Http\Controllers;

use App\Http\Requests\Person\PersonReaderRequest;
use App\Http\Requests\Person\PersonStoredRequest;
use App\Http\Requests\Person\PersonUpdatedRequest;
use App\Http\Validator;
use App\Repositories\Person\Reader\Person as PersonReaderRepository;
use App\Repositories\Person\Editor\PersonCreated as PersonCreatedRepository;
use App\Repositories\Person\Editor\PersonDeleted as PersonDeletedRepository;
use App\Repositories\Person\Editor\PersonEditable as PersonEditableRepository;
use App\Repositories\Person\Editor\PersonStored as PersonStoredRepository;
use App\Repositories\Person\Editor\PersonUpdated as PersonUpdatedRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

final class PersonController extends Controller
{
    #[OA\Get(
        path: "/api/person/create",
        responses: [
            new OA\Response(
                response: "200",
                description: "Новое лицо."
            )
        ]
    )]
    public function create(PersonCreatedRepository $repository): JsonResponse
    {
        return response()->json($repository->get());
    }

    #[OA\Post(
        path: "/api/person",
        parameters: [
            new OA\Parameter(
                name: "is_unavailable",
                description: "Доступность лица (поддерживается связь, поступает о нём известна информация).",
                required: true,
            ),
            new OA\Parameter(
                name: "is_live",
                description: "Статус живой или нет.",
                required: true,
            ),
            new OA\Parameter(
                name: "gender",
                description: "Пол (из допустимых значений).",
                required: true,
            ),
            new OA\Parameter(
                name: "surname",
                description: "Фамилия.",
                required: false,
            ),
            new OA\Parameter(
                name: "old_surname",
                description: "Прежние фамилии с порядковыми номерами.",
                required: false,
            ),
            new OA\Parameter(
                name: "name",
                description: "Имя.",
                required: false,
            ),
            new OA\Parameter(
                name: "patronymic",
                description: "Отчество.",
                required: false,
            ),
            new OA\Parameter(
                name: "has_patronymic",
                description: "Имеется ли отчество (по умолчанию отчество предполагается).",
                required: false,
            ),
            new OA\Parameter(
                name: "birth_date",
                description: "Дата рождения в формате гггг-мм-дд, вместо неизвестных цифр допустим символ ?",
                required: false,
            ),
            new OA\Parameter(
                name: "birth_place",
                description: "Место рождения.",
                required: false,
            ),
            new OA\Parameter(
                name: "death_date",
                description: "Дата смерти в формате гггг-мм-дд, вместо неизвестных цифр допустим символ ?",
                required: false,
            ),
            new OA\Parameter(
                name: "burial_place",
                description: "Место захоронения.",
                required: false,
            ),
            new OA\Parameter(
                name: "note",
                description: "Примечание.",
                required: false,
            ),
            new OA\Parameter(
                name: "activities",
                description: "Род деятельности (работа, предпринимательство, увлечения).",
                required: false,
            ),
            new OA\Parameter(
                name: "emails",
                description: "Адреса электронной почты.",
                required: false,
            ),
            new OA\Parameter(
                name: "internet",
                description: "Интернет ресурсы (страницы в соц.сетях, личные сайты).",
                required: false,
            ),
            new OA\Parameter(
                name: "phones",
                description: "Телефоны (должен состоять из 10 цифр).",
                required: false,
            ),
            new OA\Parameter(
                name: "residences",
                description: "Места проживания.",
                required: false,
            ),
            new OA\Parameter(
                name: "parents",
                description: "Родители.",
                required: false,
            ),
            new OA\Parameter(
                name: "marriages",
                description: "Отношения.",
                required: false,
            ),
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Лицо успешно сохранено."
            ),
            new OA\Response(
                response: "422",
                description: "Неверные входные данные."
            ),
        ]
    )]
    public function store(
        PersonStoredRequest $request,
        PersonStoredRepository $repository
    ): JsonResponse {
        return response()->json([
            "person_id" => $repository->store($request->getModel())
        ]);
    }

    #[OA\Get(
        path: "/api/person/{id}",
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Id запрашиваемого лица.",
                required: true,
            ),
            new OA\Parameter(
                name: "date",
                description: "Дата в формате гггг-мм-дд,
                    от которой будет идти отсчёт возраста лица и других сведений.",
                required: false,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Лицо с переданным id."
            ),
            new OA\Response(
                response: "404",
                description: "Лицо с запрошенным id не существует."
            ),
            new OA\Response(
                response: "422",
                description: "Неверный формат даты, указанной в параметрах запроса."
            ),
        ]
    )]
    public function show(
        string $id,
        PersonReaderRequest $request,
        PersonReaderRepository $repository
    ): JsonResponse {
        if (!Validator::requireInteger($id)) {
            abort(404);
        }

        return response()->json(
            $repository->getById(
                $id,
                ($request->date === null) ? config("app.datetime") : new \DateTime($request->date)
            )
        );
    }

    #[OA\Get(
        path: "/api/person/{id}/edit",
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Id запрашиваемого лица.",
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Лицо с переданным id для редактирования."
            ),
            new OA\Response(
                response: "404",
                description: "Лицо с запрошенным id не существует."
            )
        ]
    )]
    public function edit(PersonEditableRepository $repository, string $person): JsonResponse
    {
        if (!Validator::requireInteger($person)) {
            abort(404);
        }

        return response()->json(
            $repository->getById($person)
        );
    }

    #[OA\Put(
        path: "/api/person/{id}",
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Id изменяемого лица.",
                required: true,
            ),
            new OA\Parameter(
                name: "is_unavailable",
                description: "Доступность лица (поддерживается связь, поступает о нём известна информация).",
                required: true,
            ),
            new OA\Parameter(
                name: "is_live",
                description: "Статус живой или нет.",
                required: true,
            ),
            new OA\Parameter(
                name: "gender",
                description: "Пол (из допустимых значений).",
                required: true,
            ),
            new OA\Parameter(
                name: "surname",
                description: "Фамилия.",
                required: false,
            ),
            new OA\Parameter(
                name: "old_surname",
                description: "Прежние фамилии с порядковыми номерами.",
                required: false,
            ),
            new OA\Parameter(
                name: "name",
                description: "Имя.",
                required: false,
            ),
            new OA\Parameter(
                name: "patronymic",
                description: "Отчество.",
                required: false,
            ),
            new OA\Parameter(
                name: "has_patronymic",
                description: "Имеется ли отчество (по умолчанию отчество предполагается).",
                required: false,
            ),
            new OA\Parameter(
                name: "birth_date",
                description: "Дата рождения в формате гггг-мм-дд, вместо неизвестных цифр допустим символ ?",
                required: false,
            ),
            new OA\Parameter(
                name: "birth_place",
                description: "Место рождения.",
                required: false,
            ),
            new OA\Parameter(
                name: "death_date",
                description: "Дата смерти в формате гггг-мм-дд, вместо неизвестных цифр допустим символ ?",
                required: false,
            ),
            new OA\Parameter(
                name: "burial_place",
                description: "Место захоронения.",
                required: false,
            ),
            new OA\Parameter(
                name: "note",
                description: "Примечание.",
                required: false,
            ),
            new OA\Parameter(
                name: "activities",
                description: "Род деятельности (работа, предпринимательство, увлечения).",
                required: false,
            ),
            new OA\Parameter(
                name: "emails",
                description: "Адреса электронной почты.",
                required: false,
            ),
            new OA\Parameter(
                name: "internet",
                description: "Интернет ресурсы (страницы в соц.сетях, личные сайты).",
                required: false,
            ),
            new OA\Parameter(
                name: "phones",
                description: "Телефоны (должен состоять из 10 цифр).",
                required: false,
            ),
            new OA\Parameter(
                name: "residences",
                description: "Места проживания.",
                required: false,
            ),
            new OA\Parameter(
                name: "parents",
                description: "Родители.",
                required: false,
            ),
            new OA\Parameter(
                name: "marriages",
                description: "Отношения.",
                required: false,
            ),
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Лицо успешно сохранено."
            ),
            new OA\Response(
                response: "422",
                description: "Неверные входные данные."
            ),
        ]
    )]
    public function update(
        PersonUpdatedRequest $request,
        PersonUpdatedRepository $repository,
        string $person
    ): JsonResponse {
        if (!Validator::requireInteger($person)) {
            abort(404);
        }

        return response()->json([
            "person_id" => $repository->store($request->getModel())
        ]);
    }

    public function destroy(PersonDeletedRepository $repository, string $person): JsonResponse
    {
        if (!Validator::requireInteger($person)) {
            abort(404);
        }

        $repository->delete($person);

        return response()->json("OK");
    }
}
