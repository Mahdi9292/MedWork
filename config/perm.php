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

        'invoiceItem' => [
            'view'   => 'finance.invoiceItem.view',
            'create' => 'finance.invoiceItem.create',
            'update' => 'finance.invoiceItem.update',
            'delete' => 'finance.invoiceItem.delete',
        ],

        'invoiceItemType' => [
            'view'   => 'finance.invoiceItemType.view',
            'create' => 'finance.invoiceItemType.create',
            'update' => 'finance.invoiceItemType.update',
            'delete' => 'finance.invoiceItemType.delete',
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

        'preventionType' => [
            'view'   => 'medical.preventionType.view',
            'create' => 'medical.preventionType.create',
            'update' => 'medical.preventionType.update',
            'delete' => 'medical.preventionType.delete',
        ],

        'employer' => [
            'view'   => 'medical.employer.view',
            'create' => 'medical.employer.create',
            'update' => 'medical.employer.update',
            'delete' => 'medical.employer.delete',
        ],

        'employee' => [
            'view'   => 'medical.employee.view',
            'create' => 'medical.employee.create',
            'update' => 'medical.employee.update',
            'delete' => 'medical.employee.delete',
        ],

        'comment' => [
            'view'   => 'medical.comment.view',
            'create' => 'medical.comment.create',
            'update' => 'medical.comment.update',
            'delete' => 'medical.comment.delete',
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
