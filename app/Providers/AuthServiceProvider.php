<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Deposit::class => \App\Policies\DepositPolicy::class,
        \App\Models\Withdrawal::class => \App\Policies\WithdrawalPolicy::class,
        \App\Models\BotActivation::class => \App\Policies\BotActivationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
