<?php

namespace Api\Domain\Events;

use Infrastructure\Events\Event;
use Infrastructure\Database\Eloquent\AbstractModel;

class TeamWasCreated extends Event
{
    public $model;
    public $users;
    public $activatorUserData;

    public function __construct(AbstractModel $model, $users, $activatorUserData)
    {
        $this->model = $model;
        $this->users = $users;
        $this->activatorUserData = $activatorUserData;
    }
}