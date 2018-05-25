<?php namespace Turkeybone\Minifier\Facades;

use Illuminate\Support\Facades\Facade;

class MinifierFacade extends Facade
{
    /**
     * Name of the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'minifier';
    }
}
