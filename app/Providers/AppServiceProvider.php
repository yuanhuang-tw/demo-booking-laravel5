<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('interview.main', function($view) {
            $messages = \App\Message::where('start_date', '<=', date("Y-m-d", strtotime("now")))->where('end_date', '>=', date("Y-m-d", strtotime("now")))
                                                                                                ->where('department', 'p')
                                                                                                ->orderBy('id', 'desc')
                                                                                                // ->orderBy('start_date', 'asc')
                                                                                                ->get();

            $view->with('data', $messages);
        });

        view()->composer('interview.main', function($view) {
            $messages = \App\Message::where('start_date', '<=', date("Y-m-d", strtotime("now")))->where('end_date', '>=', date("Y-m-d", strtotime("now")))
                                                                                                ->where('department', 'm')
                                                                                                ->orderBy('id', 'desc')
                                                                                                // ->orderBy('start_date', 'asc')
                                                                                                ->get();

            $view->with('data_mktg', $messages);
        });

        Validator::extend('greater_than_field', function($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            $data = $validator->getData();
            $min_value = $data[$min_field];
            return $value > $min_value;
        });

        // Validator::replacer('greater_than_field', function($message, $attribute, $rule, $parameters) {
        //     return str_replace(':field', $parameters[0], $message);
        // });


        // Validator::extend('foo', function($attribute, $value, $parameters, $validator) {
        //     $date_field = $parameters[0];
        //     $d = $validator->getData();
        //     $date_value = $d[$date_field];
        //
        //     return $date_value > '2018-05-14';
        //
        //     // \App\Interview::where('s_status', 'Confirmed')
        // });
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
