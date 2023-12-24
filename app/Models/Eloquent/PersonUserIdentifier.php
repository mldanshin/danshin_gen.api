<?php

namespace App\Models\Eloquent;

use App\Models\Auth\PersonUserIdentifierType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $slug
 */
final class PersonUserIdentifier extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "people_users_identifiers";

    /**
     * @var bool
     */
    public $timestamps = false;

    public static function getIdByContent(string $string): ?PersonUserIdentifierType
    {
        if (empty($string)) {
            return null;
        } elseif (self::verifyTowardPhone($string)) {
            return PersonUserIdentifierType::PHONE;
        } elseif (self::verifyTowardEmail($string)) {
            return PersonUserIdentifierType::EMAIL;
        } else {
            return null;
        }
    }

    private static function verifyTowardPhone(string $string): bool
    {
        $pattern = "#^[0-9]+$#i";
        if (preg_match($pattern, $string)) {
            return true;
        } else {
            return false;
        }
    }

    private static function verifyTowardEmail(string $string): bool
    {
        $pattern = "#.+@.+\..+#i";
        if (preg_match($pattern, $string)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @throws \Exception
     */
    public function getType(): PersonUserIdentifierType
    {
        return match ($this->id) {
            1 => PersonUserIdentifierType::EMAIL,
            2 => PersonUserIdentifierType::PHONE,
            default => throw new \Exception("Invalid value userIdentifierType={$this->id}")
        };
    }
}
