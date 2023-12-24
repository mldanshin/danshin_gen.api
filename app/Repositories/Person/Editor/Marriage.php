<?php

namespace App\Repositories\Person\Editor;

use App\Models\Date as DateModel;
use App\Models\Eloquent\MarriageRoleGender as MarriageRoleGenderEloquentModel;
use App\Models\Eloquent\ParentChild as ParentChildEloquentModel;
use App\Models\Eloquent\People as PeopleEloquentModel;
use App\Models\Person\Editor\PersonShort as PersonShortModel;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;

final readonly class Marriage
{
    /**
     * @param Collection<int, int> $parents
     * @return Collection<int, PersonShortModel>
     */
    public function getPossiblePersonShort(
        ?int $personId,
        ?DateModel $birthDate,
        int $role,
        Collection $parents,
        PersonShort $personShortRepository
    ): Collection {
        $query = PeopleEloquentModel::select("id", "surname", "name", "patronymic", "birth_date");

        return $this->buildQueryWhere($personId, $birthDate, $role, $parents, $query)
            ->orderBy("surname")
            ->orderBy("name")
            ->orderBy("patronymic")
            ->get()
            ->map(fn($item) => $personShortRepository->getPerson($item));
    }

    /**
     * @param Collection<int, int> $parents
     * @return Collection<int, int>
     */
    public function getPossible(
        ?int $personId,
        ?DateModel $birthDate,
        int $role,
        Collection $parents
    ): Collection {
        $query = PeopleEloquentModel::select("id");

        return $this->buildQueryWhere($personId, $birthDate, $role, $parents, $query)
            ->pluck("id");
    }

    /**
     * @param Collection<int, int> $parents
     */
    private function buildQueryWhere(
        ?int $personId,
        ?DateModel $birthDate,
        int $role,
        Collection $parents,
        EloquentBuilder $query
    ): EloquentBuilder {
        if ($personId !== null) {
            $query = $query->where("id", "<>", $personId);
        }

        if ($personId !== null) {
            $query = $query->whereNotIn(
                "id",
                ParentChildEloquentModel::where("parent_id", $personId)->pluck("child_id")->all()
            );
        }

        if ($birthDate !== null && !$birthDate->hasUnknown) {
            $query = $query->where(function (EloquentBuilder $query) use ($birthDate) {
                return $query->where("death_date", ">", $birthDate->string)
                    ->orWhere("death_date", null)
                    ->orWhere("death_date", "")
                    ->orWhere("death_date", "like", "%?%");
            });
        }

        $query = $query->whereNotIn("id", $parents->all());

        return $query->whereIn(
            "gender_id",
            MarriageRoleGenderEloquentModel::where("role_id", $role)->pluck("gender_id")->all()
        );
    }
}
