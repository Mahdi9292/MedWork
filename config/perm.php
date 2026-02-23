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
    | Roles
    |--------------------------------------------------------------------------
    */

    'roles' => [
        'developer',
        'manager',
        'user',
    ],

];
