<?php

namespace Tests\Feature\Repositories\Dates\Subscription;

use App\Repositories\Dates\Subscription\Code;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CodeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testCreateNew(): void
    {
        $obj = new Code();
        $code = $obj->create(3);

        $this->assertIsString($code);
    }

    public function testCreate(): void
    {
        $code = new Code();

        $this->assertEquals("code4", $code->create(4));
    }
}
