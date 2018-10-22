<?php

namespace Laravelcity\SeoChecker;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Laravelcity\SeoChecker\Lib\Repository;

class SeoCheckerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadTranslationsFrom(__DIR__.'/Lang/', 'SeoChecker');

        // views
        $this->loadViewsFrom(__DIR__.'/Views', 'SeoChecker');

        $config = config('seochecker.route', []);

        $config['namespace'] = 'Laravelcity\SeoChecker';


        $router->group($config, function($router)
        {
            $router->any('seo/analyze', 'Controller@ajaxAnalayze')->name('seochecker.ajax');
        });

        //bind
        $this->app->bind('SeoCheckerClass',function (){
            return new Repository();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //configs
        $this->mergeConfigFrom(
            __DIR__ . '/Config/seochecker.php', 'seochecker'
        );
        $this->publishes([
            __DIR__ . '/Config/seochecker.php' => config_path('seochecker.php'),
        ],'seochecker');

    }

}