<?php

namespace Tests\Feature\Http\Controllers\Date;

use App\Models\Eloquent\SubscriberEvent as SubscriberEventModel;
use App\Models\Eloquent\Client as ClientModel;
use App\Models\Eloquent\Telegram as TelegramModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testGetData200(): void
    {
        $response = $this->getJson(
            route("dates.subscription.data", ["clientId" => 4]), $this->getHeaderUserToken()
        );
        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) =>
                $json->where('publisherUrl', config("services.telegram-bot-api.url"))
                    ->where('code', "code4")
        );

        $response = $this->getJson(
            route("dates.subscription.data", ["clientId" => 5]), $this->getHeaderUserToken()
        );
        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) =>
                $json->where('publisherUrl', config("services.telegram-bot-api.url"))
                    ->etc()
        );
    }

    public function testGetData401(): void
    {
        $response = $this->getJson(route("dates.subscription.data", ["clientId" => 1]));
        $response->assertStatus(401);
    }

    #[DataProvider('getData404Provider')]
    public function testGetData404(string $clientId): void
    {
        $response = $this->getJson(
            route("dates.subscription.data", ["clientId" => $clientId]), $this->getHeaderUserToken()
        );
        $response->assertStatus(404);
    }

    /**
     * @return array[]
     */
    public static function getData404Provider(): array
    {
        return [
            ["fake"],
            ["144"]
        ];
    }

    #[DataProvider('create200Provider')]
    public function testCreate200(array $request): void
    {
        $json = json_encode($request);

        $response = Http::withBody($json)->get(route("dates.subscription.create"));
        //$this->assertEquals(200, $response->status());
        $this->markTestSkipped(
            "Тест пропущен так как при тестировании почему то база данных не поднимается"
        );
    }

    /**
     * @return array[]
     */
    public static function create200Provider(): array
    {
        return [
            [
                [
                    "update_id" => "721483527",
                    "message" => [
                        "message_id" => "21",
                        "from" => [
                            "id" => "1370345612",
                            "username" => "danshin"
                        ],
                        "chat"=> [
                            "id" => "1370345612",
                            "username" => "danshin"
                        ],
                        "date" => "1698075501",
                        "text" => "code1"
                    ]
                ],
            ]
        ];
    }

    #[DataProvider('create404Provider')]
    public function testCreate404(array $request): void
    {
        $json = json_encode($request);

        $response = Http::withBody($json)->get(route("dates.subscription.create"));
        $this->assertEquals(404, $response->status());
    }

    /**
     * @return array[]
     */
    public static function create404Provider(): array
    {
        return [
            [
                [
                    "update_id" => "721483527",
                    "message" => [
                        "message_id" => "21",
                        "from" => [
                            "id" => "1370345612",
                            "username" => "danshin"
                        ],
                        "chat"=> [
                            "id" => "1370345612",
                            "username" => "danshin"
                        ],
                        "date" => "1698075501",
                        "text" => "344546gfewe34"
                    ]
                ],
            ]
        ];
    }

    public function testCreate422(): void
    {
        $json = json_encode([]);

        $response = Http::withBody($json)->get(route("dates.subscription.create"));
        $this->assertEquals(422, $response->status());
    }

    #[DataProvider('delete200Provider')]
    public function testDelete200(string $clientId): void
    {
        $response = $this->getJson(
            route("dates.subscription.delete", ["clientId" => $clientId]), $this->getHeaderUserToken()
        );
        $response->assertStatus(200);

        $this->assertFalse(TelegramModel::where("client_id", $clientId)->exists());

        $client = ClientModel::where("id", $clientId)->first();
        $this->assertFalse(SubscriberEventModel::where("client_id", $client->id)->exists());
    }

    /**
     * @return array[]
     */
    public static function delete200Provider(): array
    {
        return [
            ["1"],
            ["3"]
        ];
    }

    public function testDelete401(): void
    {
        $response = $this->getJson(route("dates.subscription.delete", ["clientId" => 1]));
        $response->assertStatus(401);
    }

    #[DataProvider('delete404Provider')]
    public function testDelete404(string $clientId): void
    {
        $response = $this->getJson(
            route("dates.subscription.delete", ["clientId" => $clientId]), $this->getHeaderUserToken()
        );
        $response->assertStatus(404);
    }

    /**
     * @return array[]
     */
    public static function delete404Provider(): array
    {
        return [
            ["fake"],
            ["144"]
        ];
    }

    #[DataProvider('exists200Provider')]
    public function testExists200(string $clientId, bool $res): void
    {
        $expected = fn (AssertableJson $json) =>
            $json->where('exist', $res);

        $response = $this->getJson(
            route("dates.subscription.exists", ["clientId" => $clientId]), $this->getHeaderUserToken()
        );
        $response->assertStatus(200)->assertJson($expected);
    }

    /**
     * @return array[]
     */
    public static function exists200Provider(): array
    {
        return [
            ["1", true],
            ["3", true],
            ["5", false]
        ];
    }

    public function testExists401(): void
    {
        $response = $this->getJson(route("dates.subscription.exists", ["clientId" => 1]));
        $response->assertStatus(401);
    }

    #[DataProvider('exists404Provider')]
    public function testExists404(string $clientId): void
    {
        $response = $this->getJson(
            route("dates.subscription.exists", ["clientId" => $clientId]), $this->getHeaderUserToken()
        );
        $response->assertStatus(404);
    }

    /**
     * @return array[]
     */
    public static function exists404Provider(): array
    {
        return [
            ["fake"],
            ["44"]
        ];
    }
}
