<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('curafterdate', function($attribute, $value, $parameters, $validator) {
            if(!empty($value) && ($value >= $_REQUEST['interviewfromdate'])) {
                return true;
            }
                return false;
        });
        Validator::extend('experience', function($attribute, $value, $parameters, $validator) {
            if(!empty($value) && ($value >= $_REQUEST['minimum'])) {
                return true;
            }
            if ($_REQUEST['minimum'] == 0) {
                return true;
            }
                return false;
        });
        Validator::extend('curafterdatetime', function($attribute, $value, $parameters, $validator) {
            if(!empty($value) && ((($value > $_REQUEST['intime']) && ($_REQUEST['interviewtodate'] == $_REQUEST['interviewfromdate']))|| ($_REQUEST['interviewtodate'] != $_REQUEST['interviewfromdate']))){
                return true;
            }
                return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
