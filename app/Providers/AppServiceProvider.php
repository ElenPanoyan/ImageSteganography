<?php

namespace App\Providers;
use App\Models\Encode;
use DB;

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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       
        $staff = DB::table('encodes')->orderBy('id','desc')->first();
        \View::share('staff', $staff);


    }
}
