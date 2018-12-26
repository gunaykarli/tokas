<?php

namespace App\Providers;

use App\Dealer;
use App\Office;
use App\Policies\DealerPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\OfficePolicy;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Dealer::class => DealerPolicy::class,
        Office::class => OfficePolicy::class,
        User::class => EmployeePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
