<?php

namespace Tests\Feature\Console\Commands;

use Tests\TestCase;

final class DirectoryDownloadClearTest extends TestCase
{
    public function testSuccess(): void
    {
        $this->artisan('download:clear')->assertExitCode(0);
    }
}
