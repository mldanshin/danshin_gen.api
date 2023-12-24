<?php

namespace App\Models\Eloquent;

use App\Models\Auth\PersonUserIdentifierType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

/**
 * @property int $id
 * @property int $identifier_id
 * @property string $identifier
 * @property string $password
 * @property string $timestamp
 * @property int $attempts
 * @property string $code
 * @property string $repeat_timestamp
 * @property int $repeat_attempts
 */
final class PersonUserUnconfirmed extends Model
{
    use HasFactory;
    use Notifiable;

    /**
     * @var string
     */
    protected $table = "people_users_unconfirmed";

    /**
     * @var bool
     */
    public $timestamps = false;

    public function routeNotificationForMail(Notification $notification): ?string
    {
        if ($this->getIdentifierType() === PersonUserIdentifierType::EMAIL) {
            return $this->identifier;
        } else {
            return null;
        }
    }

    public function routeNotificationForSms(Notification $notification): ?string
    {
        if ($this->getIdentifierType() === PersonUserIdentifierType::PHONE) {
            return $this->identifier;
        } else {
            return null;
        }
    }

    /**
     * @throws \Exception
     */
    public function getIdentifierType(): PersonUserIdentifierType
    {
        return match ($this->identifier_id) {
            1 => PersonUserIdentifierType::EMAIL,
            2 => PersonUserIdentifierType::PHONE,
            default => throw new \Exception("Invalid value userIdentifierType={$this->identifier_id}")
        };
    }
}
