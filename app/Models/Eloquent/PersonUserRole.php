<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $person_id
 * @property int $role_id
 */
final class PersonUserRole extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "person_user_role";

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @throws \Exception
     */
    public static function getInstanceOrDefault(int $personId): self
    {
        $model = self::where("person_id", $personId)->first();
        if ($model === null) {
            $defaultRoleId = config("auth.person_role_default");
            if (PeopleUserRole::find($defaultRoleId) === null) {
                throw new \Exception("The role_id=$defaultRoleId is missing from the database table people_users_roles");
            }

            $model = new PersonUserRole([
                "person_id" => $personId,
                "role_id" => $defaultRoleId
            ]);
        }
        return $model;
    }
}
