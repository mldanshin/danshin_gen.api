<?php

namespace Tests\Feature\Http\Controllers\Date;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    #[DataProvider('notifyAll200Provider')]
    public function testNotifyAll200(string $request): void
    {
        $this->markTestSkipped(
            "Тест пропущен, так как плохой код, и запросы происходят к телеграм боту.
            Чтобы протестировать ральные запросы к боту, расскоментируй строчку в файле TelegramSeeder
            и расскоментируй строки ниже.
            "
        );
        $response = $this->getJson(route("dates.notify_all") . $request, $this->getHeaderUserToken());
        //$response->assertStatus(200);
    }

    /**
     * @return array[]
     */
    public static function notifyAll200Provider(): array
    {
        return [
            [
                "?date=2023-04-13&past_day=1&nearest_day=2&path_person=https://fake.fake"
            ],
            [
                "?date=2023-04-12&past_day=1&nearest_day=2&path_person=https://fake.fake"
            ],
            [
                "?date=2023-04-14&past_day=2&nearest_day=2&path_person=https://fake.fake"
            ],
            [
                "?date=2023-02-04&past_day=2&nearest_day=2&path_person=https://fake.fake"
            ],
            [
                "?date=2023-02-03&past_day=2&nearest_day=2&path_person=https://fake.fake"
            ],
            [
                "?date=2023-02-05&past_day=2&nearest_day=2&path_person=https://fake.fake"
            ],
            [
                "?date=2023-10-11&past_day=2&nearest_day=2&path_person=https://fake.fake"
            ],
            [
                "?date=2023-10-10&past_day=2&nearest_day=2&path_person=https://fake.fake"
            ],
            [
                "?date=2023-10-12&past_day=2&nearest_day=2&path_person=https://fake.fake"
            ]
        ];
    }

    public function testNotifyAll401(): void
    {
        $response = $this->getJson(route("dates.notify_all"));
        $response->assertStatus(401);
    }

    #[DataProvider('notifyAll422Provider')]
    public function testNotifyAll422(string $request): void
    {
        $response = $this->getJson(route("dates.notify_all") . $request, $this->getHeaderUserToken());
        $response->assertStatus(422);
    }

    /**
     * @return array[]
     */
    public static function notifyAll422Provider(): array
    {
        return [
            ["?past_day=1&nearest_day=2"],
            ["?date=2023-04-13&nearest_day=2"],
            ["?date=2023-04-13&past_day=1"],
            [""],
            ["?date=2023-04-13&past_day=fake&nearest_day=2"],
            ["?date=2023-04-13&past_day=1&nearest_day=fake"],
            ["?date=fake&past_day=1&nearest_day=2"],
            ["?date=2023-10-11&past_day=1.1&nearest_day=2"],
            ["?date=2023-10-11&past_day=1&nearest_day=2.2"],
        ];
    }
}
