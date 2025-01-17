<?php

namespace Tests\Feature\Services\Subscription;

use App\Services\NotificationTypes;
use App\Services\Subscription\NotificationSender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;
use Tests\TestCase;

final class NotificationSenderTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testCreateObject(): NotificationSender
    {
        $obj = new NotificationSender();
        $this->assertInstanceOf(NotificationSender::class, $obj);

        return $obj;
    }

    #[Depends('testCreateObject')]
    #[DataProvider('sendProvider')]
    public function testSend(
        int $clientId,
        NotificationTypes $notificationTypes,
        NotificationSender $obj
    ): void {
        $this->markTestSkipped(
            "Тест пропущен, так как плохой код, и запросы происходят к телеграм боту.
            Чтобы протестировать ральные запросы к боту, расскоментируй строчку в файле TelegramSeeder.
            "
        );

        $obj->send($notificationTypes, $clientId);
    }

    /**
     * @return array[]
     */
    public static function sendProvider(): array
    {
        return [
            [
                1,
                NotificationTypes::TELEGRAM
            ]
        ];
    }
}
