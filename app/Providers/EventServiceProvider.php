<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\User;
use App\Observers\UserObserver;
use App\Models\Raffle;
use App\Observers\RaffleObserver;
use App\Models\Promotion;
use App\Observers\PromotionObserver;
use App\Models\Sale;
use App\Observers\SaleObserver;
use App\Models\CashRequest;
use App\Observers\CashRequestObserver;
use App\Models\Country;
use App\Observers\CountryObserver;
use App\Models\Slider;
use App\Observers\SliderObserver;
use Spatie\Permission\Models\Role;
use App\Observers\RoleObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Raffle::observe(RaffleObserver::class);
        Promotion::observe(PromotionObserver::class);
        Sale::observe(SaleObserver::class);
        CashRequest::observe(CashRequestObserver::class);
        Country::observe(CountryObserver::class);
        Slider::observe(SliderObserver::class);
        Role::observe(RoleObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
