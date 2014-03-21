<?php

namespace Saxulum\SaxulumControllerProvider\Provider;

use Saxulum\SaxulumControllerProvider\Map\Controller;
use Saxulum\SaxulumControllerProvider\Map\Map;
use Silex\Application;
use Silex\ServiceProviderInterface;

class SaxulumControllerProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['controller.map'] = $app->share(function () {
            return new Map();
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
            $controllerReflection = new \ReflectionClass($controllerNamespace);
            if($controllerReflection->implementsInterface('Saxulum\SaxulumControllerProvider\Controller\ControllerRouteInterface') &&
               !$controllerReflection->isAbstract() &&
               !$controllerReflection->isInterface()) {
                $app[$controller->getServiceId()] = $app->share(function () use ($app, $controller, $controllerNamespace, $controllerReflection) {
                    if ($controller->isInjectContainer()) {
                        return new $controllerNamespace($app);
                    }
                    $controllerInstance = SaxulumControllerProvider::constructController($app, $controller, $controllerReflection);
                    SaxulumControllerProvider::methodInjections($app, $controller, $controllerReflection, $controllerInstance);

                    return $controllerInstance;
                });
                $controllerNamespace::addRoutes($app, $controller->getServiceId());
            }
        }
    }

    /**
     * @param  Application      $app
     * @param  Controller       $controller
     * @param  \ReflectionClass $controllerReflection
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
     * @param Application      $app
     * @param Controller       $controller
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
