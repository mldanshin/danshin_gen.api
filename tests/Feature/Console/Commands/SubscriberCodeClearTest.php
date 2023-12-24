<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Eloquent\SubscriberCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SubscriberCodeClearTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testSuccess(): void
    {
        $this->artisan('code:clear')->assertExitCode(0);

        $this->assertTrue(SubscriberCode::where("id", 1)->exists());
        $this->assertFalse(SubscriberCode::where("id", 2)->exists());
        $this->assertFalse(SubscriberCode::where("id", 3)->exists());
    }
}
