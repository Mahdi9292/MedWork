<?php
namespace App\Providers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Medical\Patient;
use App\Models\Medical\Activity;
use App\Models\Medical\Certificate;
use App\Models\Medical\Prevention;

use App\Policies\UserPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\Medical\PatientPolicy;
use App\Policies\Medical\ActivityPolicy;
use App\Policies\Medical\CertificatePolicy;
use App\Policies\Medical\PreventionPolicy;

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
        Patient::class => PatientPolicy::class,
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
