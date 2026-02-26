<?php
namespace App\Providers;

use App\Models\Finance\Invoice;
use App\Models\Medical\Activity;
use App\Models\Medical\Certificate;
use App\Models\Medical\Patient;
use App\Models\Medical\Prevention;
use App\Models\User;
use App\Policies\Finance\InvoicePolicy;
use App\Policies\Medical\ActivityPolicy;
use App\Policies\Medical\CertificatePolicy;
use App\Policies\Medical\PreventionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [

        // Invoice
        Invoice::class => InvoicePolicy::class,

        // User
        User::class => UserPolicy::class,

        // Medical
        Certificate::class => CertificatePolicy::class,
        Prevention::class => PreventionPolicy::class,
        Activity::class => ActivityPolicy::class,
    ];

    public function boot(): void
    {
        // Implicitly grant "Developers" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user) {
            return $user->hasRole('developer') ? true : null;
        });

        $this->registerPolicies();
    }
}
