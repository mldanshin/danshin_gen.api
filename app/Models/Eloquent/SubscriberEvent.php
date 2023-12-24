<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $telegram_id
 * @property string|null $created_at
 * @property string|null $updated_at
 */
final class SubscriberEvent extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "subscribers_events";

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
