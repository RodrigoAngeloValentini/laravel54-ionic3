<?php

namespace CodeFlix\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Dingo\Api\Event\ResponseWasMorphed::class => [
            \CodeFlix\Listeners\AddTokenToHeaderListener::class
        ],
        \CodeFlix\Events\PayPalPaymentApproved::class => [
            \CodeFlix\Listeners\CreateOrderListener::class
        ],
        \Prettus\Repository\Events\RepositoryEntityCreated::class => [
            \CodeFlix\Listeners\CreateSubscriptionListener::class,
            \CodeFlix\Listeners\CreatePayPalWebProfileListener::class,
        ],
        \Prettus\Repository\Events\RepositoryEntityUpdated::class => [
            \CodeFlix\Listeners\UpdatePayPalWebProfileListener::class
        ],
        \Prettus\Repository\Events\RepositoryEntityDeleted::class => [
            \CodeFlix\Listeners\DeletePayPalWebProfileListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
