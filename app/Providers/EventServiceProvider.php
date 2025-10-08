<?php

namespace App\Providers;

use App\Events\BotActivated;
use App\Events\BotClosed;
use App\Events\DepositApproved;
use App\Events\WithdrawalApproved;
use App\Listeners\LogBotActivated;
use App\Listeners\LogBotClosed;
use App\Listeners\LogDepositApproved;
use App\Listeners\LogWithdrawalApproved;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        BotActivated::class => [
            LogBotActivated::class,
        ],
        BotClosed::class => [
            LogBotClosed::class,
        ],
        DepositApproved::class => [
            LogDepositApproved::class,
        ],
        WithdrawalApproved::class => [
            LogWithdrawalApproved::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
