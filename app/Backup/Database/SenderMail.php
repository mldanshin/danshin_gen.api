<?php

namespace App\Backup\Database;

use App\Mail\Backup\Database\Database as DatabaseMail;
use Illuminate\Support\Facades\Mail;

final class SenderMail implements SenderContract
{
    public function send(string $pathDb): bool
    {
        Mail::to(config("mail.from.address"))->send(new DatabaseMail($pathDb));

        return true;
    }
}