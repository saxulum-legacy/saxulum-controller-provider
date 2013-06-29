<?php

namespace Saxulum\SaxulumControllerProvider\Provider;

use Saxulum\SaxulumControllerProvider\Map\Controller;
use Saxulum\SaxulumControllerProvider\Map\Method;
use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\WebTestCase;

class SaxulumControllerProviderTest extends WebTestCase
{
    public function testInjectController()
    {
        $client = $this->createClient();

        $client->request('GET', '/container');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals('ok', $client->getResponse()->getContent());

        $client->request('GET', '/service');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals('ok', $client->getResponse()->getContent());
    }

    public function createApplication()
    {
        $app = new Application();
        $app['debug'] = true;

        $app->register(new ServiceControllerServiceProvider());
        $app->register(new SaxulumControllerProvider());

        $controller = new Controller();
        $controller->setNamespace('Saxulum\SaxulumControllerProvider\Controller\ContainerExampleController');
        $controller->setServiceId('saxulum.saxulumcontrollerprovider.controller.containerinjectcontroller');
        $controller->setInjectContainer(true);
        $app['controller.map']->addController($controller);

        $method = new Method();
        $method->setName('setTestData');
        $method->setInjectionKeys(array('test.data'));

        $controller = new Controller();
        $controller->setNamespace('Saxulum\SaxulumControllerProvider\Controller\ServiceExampleController');
        $controller->setServiceId('saxulum.saxulumcontrollerprovider.controller.serviceController');
        $controller->setInjectionKeys(array('test.data'));
        $controller->addMethod($method);
        $app['controller.map']->addController($controller);

        $app['test.data'] = array(
            'key1' => 'value1'
        );

        return $app;
    }
}
