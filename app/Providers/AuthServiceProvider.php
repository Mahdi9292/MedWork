<?php
namespace App\Providers;

use App\Models\Finance\Invoice;
use App\Models\Medical\Activity;
use App\Models\Medical\Certificate;
use App\Models\Medical\Comment;
use App\Models\Medical\Employee;
use App\Models\Medical\Employer;
use App\Models\Medical\Prevention;
use App\Models\Medical\PreventionType;
use App\Models\User;
use App\Policies\Finance\InvoicePolicy;
use App\Policies\Medical\ActivityPolicy;
use App\Policies\Medical\CertificatePolicy;
use App\Policies\Medical\CommentPolicy;
use App\Policies\Medical\EmployeePolicy;
use App\Policies\Medical\EmployerPolicy;
use App\Policies\Medical\PreventionPolicy;
use App\Policies\Medical\PreventionTypePolicy;
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
        Employer::class => EmployerPolicy::class,
        Employee::class => EmployeePolicy::class,
        Comment::class => CommentPolicy::class,
        PreventionType::class => PreventionTypePolicy::class,
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
