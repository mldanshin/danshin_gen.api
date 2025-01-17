<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $client_id
 * @property string $telegram_id
 * @property string|null $telegram_username
 * @property string|null $created_at
 * @property string|null $updated_at
 */
final class Telegram extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "telegram";
}
