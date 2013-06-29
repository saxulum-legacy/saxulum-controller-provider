<?php

namespace Saxulum\SaxulumControllerProvider\Controller;

use Silex\Application;

interface ControllerRouteInterface
{
    public static function addRoutes(Application $app, $serviceId);
}
