<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $client_id
 * @property string $code
 * @property int $time
 */
final class SubscriberCode extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "subscribers_codes";

    /**
     * @var bool
     */
    public $timestamps = false;
}
