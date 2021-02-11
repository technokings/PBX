<?php

return [

    'domain' => [
        'enabled' => env('FPBX_DOMAIN_ENABLED', true),
        'description' => env('FPBX_DOMAIN_DESCRIPTION', 'Created via api at ' . date( 'Y-m-d H:i:s', time() )),
    ],

    /**
     * Overrides model level defined fillable fields
     */
    'table' => [
        // Example
        // 'v_domain_settings' => [
        //     'mergeFillable' => [
        //         'app_uuid',
        //     ],
        //     ' mergeGuarded' => [
        //         'domain_setting_category',
        //     ],
        // ]
        // 'v_domains' => [
        //     'mergeGuarded' => [
        //         'domain_enabled'
        //     ]
        // ],
        // 'v_users' => [
        //     'mergeGuarded' => [
        //         'add_user'
        //     ],
        //     'makeHidden' => [
        //         'add_user'
        //     ],
        //     'makeVisible' => [
        //         'salt'
        //     ],
        // ]
    ]

];