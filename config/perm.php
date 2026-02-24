<?php

return [

    'invoice' => [
        'view'   => 'invoice.view',
        'create' => 'invoice.create',
        'update' => 'invoice.update',
        'delete' => 'invoice.delete',
    ],

    'service' => [
        'view'   => 'service.view',
        'create' => 'service.create',
        'update' => 'service.update',
        'delete' => 'service.delete',
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
            'create' => 'medical.prevention.view',
            'update' => 'medical.prevention.view',
            'delete' => 'medical.prevention.view',
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
