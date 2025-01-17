<?php

namespace Tests\Feature\Console\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SenderDatesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testSuccess(): void
    {
        $this->markTestSkipped(
            "Тест пропущен, так как плохой код, и запросы происходят к телеграм боту.
            Чтобы протестировать ральные запросы к боту, расскоментируй строчку в файле TelegramSeeder
            и расскоментируй строки ниже.
            "
        );
        //$this->artisan('send:dates https://fake.fake')->assertExitCode(0);
        //$this->artisan('send:dates https://fake.fake 2022-04-13 2 2')->assertExitCode(1);
    }
}
