<?php

namespace App\Models\Eloquent;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

/**
 * @property int $id
 * @property string $uid
 */
final class Client extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * @var string
     */
    protected $table = "clients";

    /**
     * @var bool
     */
    public $timestamps = false;

    public function telegram(): HasMany
    {
        return $this->hasMany(Telegram::class, "client_id", "id");
    }

    public function subscriptionEvent(): hasOne
    {
        return $this->hasOne(SubscriberEvent::class, "client_id", "id");
    }

    public function isSubscription(): bool
    {
        return $this->subscriptionEvent()->exists();
    }

    public function routeNotificationForTelegram(Notification $notification): ?string
    {
        return $this->telegram()->first()?->telegram_id;
    }
}
