<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testShow200(): void
    {
        $expected = fn (AssertableJson $json) =>
            $json->where("id", 3)
                ->where("uid", "DSDCQSQQCWODSD");

        $response = $this->getJson(
            route("client.show", ["uid" => "DSDCQSQQCWODSD"]),
            $this->getHeaderAdminToken()
        );
        $response->assertStatus(200)->assertJson($expected);
    }

    public function testShow401(): void
    {
        $response = $this->getJson(route("client.show", ["uid" => "fake"]));
        $response->assertStatus(401);
    }

    public function testShow403(): void
    {
        $response = $this->getJson(
            route("client.show", ["uid" => "fake"]),
            $this->getHeaderUserToken()
        );
        $response->assertStatus(403);
    }

    public function testShow404(): void
    {
        $response = $this->getJson(
            route("client.show", ["uid" => "fake"]),
            $this->getHeaderAdminToken()
        );
        $response->assertStatus(404);
    }

    #[DataProvider('store200Provider')]
    public function testStore200(array $request, callable $expected): void
    {
        $response = $this->postJson(
            route("client.store"),
            $request,
            $this->getHeaderAdminToken()
        );
        $response->assertStatus(200)->assertJson($expected);
    }

    /**
     * @return array[]
     */
    public static function store200Provider(): array
    {
        return [
            [
                [
                    "uid" => "DSDWEWENJJLJKJ"
                ],
                fn (AssertableJson $json) =>
                    $json->where("id", 6)
                        ->where("uid", "DSDWEWENJJLJKJ")
            ],
            [
                [
                    "uid" => "DSWEWEDLPPOKKP"
                ],
                fn (AssertableJson $json) =>
                    $json->where("id", 4)
                        ->where("uid", "DSWEWEDLPPOKKP")
            ],
        ];
    }

    public function testStore401(): void
    {
        $response = $this->postJson(route("client.store"));
        $response->assertStatus(401);
    }

    public function testStore403(): void
    {
        $response = $this->postJson(
            uri: route("client.store"),
            headers: $this->getHeaderUserToken()
        );
        $response->assertStatus(403);
    }

    public function testDestroy200(): void
    {
        $response = $this->deleteJson(
            uri: route("client.show", ["uid" => "DSDCQSQQCWODSD"]),
            headers: $this->getHeaderAdminToken()
        );
        $response->assertStatus(200);

        $response = $this->getJson(
            uri: route("client.show", ["uid" => "DSDCQSQQCWODSD"]),
            headers: $this->getHeaderAdminToken()
        );
        $response->assertStatus(404);
    }

    public function testDestroy401(): void
    {
        $response = $this->deleteJson(route("client.destroy", ["uid" => "fake"]));
        $response->assertStatus(401);
    }

    public function testDestroy403(): void
    {
        $response = $this->deleteJson(
            uri: route("client.destroy", ["uid" => "fake"]),
            headers: $this->getHeaderUserToken()
        );
        $response->assertStatus(403);
    }

    public function testDestroy404(): void
    {
        $response = $this->deleteJson(
            uri: route("client.destroy", ["uid" => "fake"]),
            headers: $this->getHeaderAdminToken()
        );
        $response->assertStatus(404);
    }
}
