<?php

namespace App\Providers;

use App\Repositories\Dates\Subscription\Contract as SubscriptionContract;
use App\Repositories\Dates\Subscription\Telegram as TelegramSubscription;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        SubscriptionContract::class => TelegramSubscription::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
