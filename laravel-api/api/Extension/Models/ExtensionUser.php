<?php

namespace Api\Extension\Models;

use Illuminate\Notifications\Notifiable;
use Infrastructure\Database\Eloquent\AbstractModel;

class ExtensionUser extends AbstractModel
{
    use Notifiable;

    protected $fillable = [
        'domain_uuid',
        'extension_uuid',
        'user_uuid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // ~ 'password',
    ];
}
