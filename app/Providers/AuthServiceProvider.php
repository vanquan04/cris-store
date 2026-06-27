<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('role.view', function (User $user) {
        //     return  $user->hasPermission('role.view');
        // });

        // $permissions = Permission::all();
        // foreach ($permissions as $permission) {
        //     Gate::define($permission->slug, function (User $user) use ($permission) {
        //         return  $user->hasPermission($permission->slug);
        //     });
        // }
    }
}
