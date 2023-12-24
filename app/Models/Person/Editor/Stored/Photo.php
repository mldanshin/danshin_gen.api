<?php

namespace App\Models\Person\Editor\Stored;

use App\Models\Date;
use Illuminate\Http\UploadedFile;

final readonly class Photo
{
    public function __construct(
        public int $order,
        public ?Date $date,
        public UploadedFile $file
    ) {
    }
}
