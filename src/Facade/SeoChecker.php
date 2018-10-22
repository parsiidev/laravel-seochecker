<?php
namespace Laravelcity\SeoChecker\Facade;

use Illuminate\Support\Facades\Facade;

class SeoChecker extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'SeoCheckerClass';
    }
}