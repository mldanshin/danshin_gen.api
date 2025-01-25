<?php

namespace Tests\Feature\Console\Commands;

use Tests\TestCase;

final class PhotoTempClearTest extends TestCase
{
    public function testSuccess(): void
    {
        $this->artisan('photo:clear')->assertExitCode(0);
    }
}
