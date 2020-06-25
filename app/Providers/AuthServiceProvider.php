<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Auth;
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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('remember_token', function ($request) {
            return User::where('remember_token', $request->remember_token)->with('team', 'team.user', 'staffdetails', 'personneldetails', 'linemanager', 'linemanager.manager')->first();
        });
        //look into changing to use sessions instead maybe?
        //note: sessions currently delete after login for security purposes
    }
}
