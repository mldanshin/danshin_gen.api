<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Eloquent\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class IndexControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testIndex(): void
    {
        $response = $this->actingAs($this->getAdmim())->get(route("index"));
        $response->assertStatus(200);
    }

    private function getAdmim(): UserModel
    {
        return UserModel::find(4);
    }
}
