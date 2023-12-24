<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $slug
 */
final class PeopleUserRole extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "people_users_roles";

    /**
     * @var bool
     */
    public $timestamps = false;
}
