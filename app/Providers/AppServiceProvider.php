<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
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
        Validator::extend('check_username', function($attribute, $value) {
            return preg_match('/^(?=[a-zA-Z0-9._]{5,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/', $value);
        }, 'Username is invalid.');

        Validator::extend('check_age', function($attribute, $value, $parameters)
        {
            $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 13;

            return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
        });

        \Illuminate\Database\Query\Builder::macro('toRawSql', function () {
            $sql = str_replace(['%', '?'], ['%%', '%s'], $this->toSql());

            $handledBindings = array_map(function ($binding) {
                if (is_numeric($binding)) {
                    return $binding;
                }

                $value = str_replace(['\\', "'"], ['\\\\', "\'"], $binding);

                return "'{$value}'";
            }, $this->getConnection()->prepareBindings($this->getBindings()));

            $fullSql = vsprintf($sql, $handledBindings);

            return $fullSql;
        });

        \Illuminate\Database\Eloquent\Builder::macro('toRawSql', function () {
            return ($this->getQuery()->toRawSql());
        });

        Paginator::defaultView('pagination.bootstrap-4');
    }
}
