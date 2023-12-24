<?php

namespace App\Backup\Database;

interface SenderContract
{
    public function send(string $pathDb): bool;
}
