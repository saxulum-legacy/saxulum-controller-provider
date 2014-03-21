<?php

namespace Saxulum\SaxulumControllerProvider\Controller;

use Silex\Application;

interface ControllerRouteInterface
{
    /**
     * @param  Application $app
     * @param  string      $serviceId
     * @return void
     */
    public static function addRoutes(Application $app, $serviceId);
}
