<?php

namespace Saxulum\SaxulumControllerMap\Provider;

use Saxulum\SaxulumControllerMap\ControllerMap\Controller;
use Saxulum\SaxulumControllerMap\ControllerMap\ControllerMap;
use Silex\Application;
use Silex\ServiceProviderInterface;

class SaxulumControllerMapProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['controller.map'] = $app->share(function() {
            return new ControllerMap();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
        foreach ($app['controller.map']->getControllers() as $controller) {
            /** @var Controller $controller */
            $controllerNamespace = $controller->getNamespace();
            $app[$controller->getServiceId()] = $app->share(function() use ($app, $controller, $controllerNamespace) {
                if($controller->isInjectContainer()) {
                    return new $controllerNamespace($app);
                }

                $controllerReflection = new \ReflectionClass($controllerNamespace);
                $controllerInstance = SaxulumControllerMapProvider::constructController($app, $controller, $controllerReflection);
                SaxulumControllerMapProvider::methodInjections($app, $controller, $controllerReflection, $controllerInstance);

                return $controllerInstance;
            });
            $controllerNamespace::addRoutes($app, $controller->getServiceId());
        }
    }

    /**
     * @param Application $app
     * @param Controller $controller
     * @param \ReflectionClass $controllerReflection
     * @return object
     */
    public static function constructController(Application $app, Controller $controller, \ReflectionClass $controllerReflection)
    {
        if ($controller->hasInjectionKeys()) {
            $args = array();
            foreach ($controller->getInjectionKeys() as $injectionKey) {
                if (isset($app[$injectionKey])) {
                    $args[] = $app[$injectionKey];
                }
            }
            $controllerInstance = $controllerReflection->newInstanceArgs($args);
        } else {
            $controllerInstance = $controllerReflection->newInstance();
        }

        return $controllerInstance;
    }

    /**
     * @param Application $app
     * @param Controller $controller
     * @param \ReflectionClass $controllerReflection
     * @param $controllerInstance
     */
    public static function methodInjections(Application $app, Controller $controller, \ReflectionClass $controllerReflection, $controllerInstance)
    {
        foreach ($controller->getMethods() as $method) {
            $methodReflection = $controllerReflection->getMethod($method->getName());
            $args = array();
            foreach ($method->getInjectionKeys() as $injectionKey) {
                if (isset($app[$injectionKey])) {
                    $args[] = $app[$injectionKey];
                }
            }
            $methodReflection->invokeArgs($controllerInstance, $args);
        }
    }
}