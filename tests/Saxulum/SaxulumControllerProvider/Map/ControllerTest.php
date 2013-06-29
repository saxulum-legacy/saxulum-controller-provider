<?php

namespace Saxulum\SaxulumControllerProvider\Map;

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testScenario1()
    {
        $namespace = 'Saxulum\SaxulumControllerProvider\Controller\TestController';
        $serviceId = 'saxulum.saxulumcontrollerprovider.controller.testcontroller';

        $controller = new Controller();
        $controller->setNamespace($namespace);
        $controller->setServiceId($serviceId);
        $controller->setInjectContainer(true);

        $this->assertEquals($namespace, $controller->getNamespace());
        $this->assertEquals($serviceId, $controller->getServiceId());
        $this->assertFalse($controller->hasInjectionKeys());
        $this->assertTrue($controller->isInjectContainer());
        $this->assertFalse($controller->hasMethods());

        $newController = new Controller($controller->__toArray());
        $this->assertEquals($controller->__toArray(), $newController->__toArray());
    }

    public function testScenario2()
    {
        $namespace = 'Saxulum\SaxulumControllerProvider\Controller\TestController';
        $serviceId = 'saxulum.saxulumcontrollerprovider.controller.testcontroller';
        $injectionKeys = array('doctrine', 'twig');

        $controller = new Controller();
        $controller->setNamespace($namespace);
        $controller->setServiceId($serviceId);
        $controller->setInjectionKeys($injectionKeys);

        $this->assertEquals($namespace, $controller->getNamespace());
        $this->assertEquals($serviceId, $controller->getServiceId());
        $this->assertEquals($injectionKeys, $controller->getInjectionKeys());
        $this->assertTrue($controller->hasInjectionKeys());
        $this->assertFalse($controller->isInjectContainer());

        $newController = new Controller($controller->__toArray());
        $this->assertEquals($controller->__toArray(), $newController->__toArray());
    }

    public function testScenario3()
    {
        $namespace = 'Saxulum\SaxulumControllerProvider\Controller\TestController';
        $serviceId = 'saxulum.saxulumcontrollerprovider.controller.testcontroller';

        $methodArray = array(
            'name' => 'setDoctrine',
            'injectionKeys' => array('doctrine'),
        );
        $method = $this->getMock('Saxulum\SaxulumControllerProvider\Map\Method');

        $method
            ->expects($this->any())
            ->method('__toArray')
            ->will($this->returnValue($methodArray))
        ;

        $controller = new Controller();
        $controller->setNamespace($namespace);
        $controller->setServiceId($serviceId);
        $controller->addMethod($method);

        $this->assertEquals($namespace, $controller->getNamespace());
        $this->assertEquals($serviceId, $controller->getServiceId());
        $this->assertFalse($controller->hasInjectionKeys());
        $this->assertFalse($controller->isInjectContainer());
        $this->assertTrue($controller->hasMethods());

        $newController = new Controller($controller->__toArray());
        $this->assertEquals($controller->__toArray(), $newController->__toArray());
    }

    public function testScenario4()
    {
        $namespace = 'Saxulum\SaxulumControllerProvider\Controller\TestController';
        $serviceId = 'saxulum.saxulumcontrollerprovider.controller.testcontroller';
        $injectionKeys = array('twig');

        $methodArray = array(
            'name' => 'setDoctrine',
            'injectionKeys' => array('doctrine'),
        );
        $method = $this->getMock('Saxulum\SaxulumControllerProvider\Map\Method');

        $method
            ->expects($this->any())
            ->method('__toArray')
            ->will($this->returnValue($methodArray))
        ;

        $controller = new Controller();
        $controller->setNamespace($namespace);
        $controller->setServiceId($serviceId);
        $controller->setInjectionKeys($injectionKeys);
        $controller->addMethod($method);

        $this->assertEquals($namespace, $controller->getNamespace());
        $this->assertEquals($serviceId, $controller->getServiceId());
        $this->assertEquals($injectionKeys, $controller->getInjectionKeys());
        $this->assertTrue($controller->hasInjectionKeys());
        $this->assertFalse($controller->isInjectContainer());
        $this->assertTrue($controller->hasMethods());

        $newController = new Controller($controller->__toArray());
        $this->assertEquals($controller->__toArray(), $newController->__toArray());
    }
}
