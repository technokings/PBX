<?php

namespace Api\User;

use Api\User\Events\UserWasCreated;
use Api\User\Events\UserWasDeleted;
use Api\User\Events\UserWasUpdated;
use Api\User\Events\GroupWasCreated;
use Api\User\Events\GroupWasDeleted;
use Api\User\Events\GroupWasUpdated;
use Api\User\Events\UserWasActivated;
use Api\User\Listeners\UserWasCreatedListener;
use Api\User\Listeners\UserWasActivatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    protected $listen = [
        GroupWasCreated::class => [
            // listeners for when a role is created
        ],
        GroupWasDeleted::class => [
            // listeners for when a role is deleted
        ],
        GroupWasUpdated::class => [
            // listeners for when a role is updated
        ],
        UserWasCreated::class => [
            // listeners for when a user is created
            UserWasCreatedListener::class,
        ],
        UserWasDeleted::class => [
            // listeners for when a user is deleted
        ],
        UserWasUpdated::class => [
            // listeners for when a user is updated
        ],
        UserWasActivated::class => [
            UserWasActivatedListener::class,
        ],
    ];
}
