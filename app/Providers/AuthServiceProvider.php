<?php

namespace App\Providers;

use App\Repositories\PengawasanRegulerRepositories;
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
        Gate::define('master',function($user){
            $role = $user->user_level->alias;
            $role_allowed = ["admin"];
            if(in_array($role, $role_allowed))
                return true;
            return false;
        });

        Gate::define('pengawasan-tl.view',"App\Policies\PengawasanTindaklanjutPolicy@view");
        Gate::define('pengawasan-tl',"App\Policies\PengawasanTindaklanjutPolicy@action");
        Gate::define('pengawasan-hawasbid.view',"App\Policies\PengawasanHawasbidPolicy@view");
        Gate::define('pengawasan-hawasbid',"App\Policies\PengawasanHawasbidPolicy@action");
        Gate::define('kesesuaian.view',"App\Policies\KesesuaianPengawasanRegularPolicy@view");
        Gate::define('kesesuaian',"App\Policies\KesesuaianPengawasanRegularPolicy@action");
        Gate::define('dokumentasirapat.view',"App\Policies\DokumentasiRapatPolicy@view");
        Gate::define('dokumentasirapat',"App\Policies\DokumentasiRapatPolicy@action");

    }
}
