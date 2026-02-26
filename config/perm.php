<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Finance
    |--------------------------------------------------------------------------
    */
    'finance' => [
        'invoice' => [
            'view'   => 'finance.invoice.view',
            'create' => 'finance.invoice.create',
            'update' => 'finance.invoice.update',
            'delete' => 'finance.invoice.delete',
        ],

        'service' => [
            'view'   => 'finance.service.view',
            'create' => 'finance.service.create',
            'update' => 'finance.service.update',
            'delete' => 'finance.service.delete',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Medical
    |--------------------------------------------------------------------------
    */
    'medical' => [
        'certificate' => [
            'view'      => 'medical.certificate.view',
            'create'    => 'medical.certificate.create',
            'update'    => 'medical.certificate.update',
            'delete'    => 'medical.certificate.delete',
        ],

        'prevention' => [
            'view'   => 'medical.prevention.view',
            'create' => 'medical.prevention.create',
            'update' => 'medical.prevention.update',
            'delete' => 'medical.prevention.delete',
        ],

        'activity' => [
            'view'   => 'medical.activity.view',
            'create' => 'medical.activity.create',
            'update' => 'medical.activity.update',
            'delete' => 'medical.activity.delete',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    'roles' => [
        'developer',
        'manager',
        'user',
    ],

];
