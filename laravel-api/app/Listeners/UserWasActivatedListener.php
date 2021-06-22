<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Notification;

use App\Notifications\UserWasActivatedSelfNotification;
use App\Notifications\UserWasActivatedDomainAdminNotification;

class UserWasActivatedListener
{
    public function handle($event)
    {
        if ($event->sendNotification) {
            Notification::send($event->user, new UserWasActivatedSelfNotification($event->user));
        }

        $admins = $event->user->getDomainAdmins();
        Notification::send($admins, new UserWasActivatedDomainAdminNotification($event->user));

        $mainAdminEmail = config('mail.from.address');

        Notification::route('mail', $mainAdminEmail)
            ->notify(new UserWasActivatedDomainAdminNotification($event->user));


        /**
         * @var \App\Models\User
         */
        $user = $event->user;
        $user->extensions()->update(['enabled' => 'true']);
    }
}