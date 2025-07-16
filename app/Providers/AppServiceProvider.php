<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\Item;
use App\Policies\MessagePolicy;
use App\Policies\ItemPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Message::class => MessagePolicy::class,
        Item::class => ItemPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
