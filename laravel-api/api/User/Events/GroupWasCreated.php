<?php

namespace Api\User\Events;

use App\Events\Event;
use Api\User\Models\Group;

class GroupWasCreated extends Event
{
    public $group;

    public function __construct(Group $group)
    {
        $this->group = $group;
    }
}
