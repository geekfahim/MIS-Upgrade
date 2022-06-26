<?php

namespace App\Providers;

use App\Models\Base\Acl\User;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::unguard();
        Schema::defaultStringLength(191);
        Relation::enforceMorphMap([
            'user' => User::class,
            'mustahiq' => Mustahiq::class,
            'jProject' => JProject::class,
            'jBusinessPlan' => JBusinessPlan::class,
        ]);
    }
}
