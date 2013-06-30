saxulum controller provider
===========================

**works with plain silex-php**

[![Build Status](https://api.travis-ci.org/saxulum/saxulum-controller-provider.png?branch=master)](https://travis-ci.org/saxulum/saxulum-controller-provider)
[![Total Downloads](https://poser.pugx.org/saxulum/saxulum-controller-provider/downloads.png)](https://packagist.org/packages/saxulum/saxulum-controller-provider)
[![Latest Stable Version](https://poser.pugx.org/saxulum/saxulum-controller-provider/v/stable.png)](https://packagist.org/packages/saxulum/saxulum-controller-provider)

Features
--------

* Register Controllers as a Service with container, __construct and method injection
* register their actions over a static method within the controller

Requirements
------------

* php >=5.3
* silex/silex ~1.0

Installation
------------

The [ServiceControllerServiceProvider][1] from silex itself is needed!

```php
$app->register(new ServiceControllerServiceProvider());
$app->register(new SaxulumControllerProvider());
```

Usage
-----

The example controllers [ContainerExampleController][2] and [ServiceExampleController][3] they implement [ControllerRouteInterface][4]

```php
public static function addRoutes(Application $app, $serviceId)
{
    $app
        ->get('/container', $serviceId . ':indexAction')
        ->bind('container_index')
    ;
}
```

```php
$app['controller.map']
    ->addController(new Controller)
        ->setNamespace('Saxulum\SaxulumControllerProvider\Controller\ContainerExampleController')
        ->setServiceId('saxulum.saxulumcontrollerprovider.controller.containerinjectcontroller')
        ->setInjectContainer(true)
    ->end()
    ->addController(new Controller)
        ->setNamespace('Saxulum\SaxulumControllerProvider\Controller\ServiceExampleController')
        ->setServiceId('saxulum.saxulumcontrollerprovider.controller.serviceController')
        ->setInjectionKeys(array('test.data'))
        ->addMethod(new Method)
            ->setName('setTestData1')
            ->setInjectionKeys(array('test.data'))
        ->end()
        ->addMethod(new Method)
            ->setName('setTestData2')
            ->setInjectionKeys(array('test.data'))
        ->end()
    ->end()
;
```

[1]: http://silex.sensiolabs.org/doc/providers/service_controller.html
[2]: https://github.com/saxulum/saxulum-controller-provider/blob/master/src/Saxulum/SaxulumControllerProvider/Controller/ContainerExampleController.php
[3]: https://github.com/saxulum/saxulum-controller-provider/blob/master/src/Saxulum/SaxulumControllerProvider/Controller/ServiceExampleController.php
[4]: https://github.com/saxulum/saxulum-controller-provider/blob/master/src/Saxulum/SaxulumControllerProvider/Controller/ControllerRouteInterface.php