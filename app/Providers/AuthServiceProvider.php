<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Turnover\Models\Transaction\Transaction;
use Turnover\Models\User\User;
use Turnover\Transaction\TransactionPolicy;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Transaction::class => TransactionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('can-purchase', function (User $user) {
            return ! $user->is_admin;
        });

        Gate::define('can-deposit', function (User $user) {
            return ! $user->is_admin;
        });

        Gate::define('can-accept-deposit', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('can-reprove-deposit', function (User $user) {
            return $user->is_admin;
        });
    }
}
