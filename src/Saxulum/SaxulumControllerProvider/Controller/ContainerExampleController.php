<?php

namespace Saxulum\SaxulumControllerProvider\Controller;

use Silex\Application;

class ContainerExampleController implements ControllerRouteInterface
{
    /**
     * @var \Pimple
     */
    protected $container;

    public static function addRoutes(Application $app, $serviceId)
    {
        $app
            ->get('/container', $serviceId . ':indexAction')
            ->bind('container_index')
        ;
    }

    /**
     * @param \Pimple $container
     */
    public function __construct(\Pimple $container)
    {
        $this->container = $container;
    }

    public function indexAction()
    {
        return $this->container instanceof \Pimple ? 'ok': '';
    }
}
