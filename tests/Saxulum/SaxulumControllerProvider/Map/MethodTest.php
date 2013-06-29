<?php

namespace Saxulum\SaxulumControllerProvider\Map;

class MethodTest extends \PHPUnit_Framework_TestCase
{
    public function testScenario1()
    {
        $name = 'setDoctrine';
        $injectionKeys = array('doctrine');

        $method = new Method();
        $method->setName($name);
        $method->setInjectionKeys($injectionKeys);

        $this->assertEquals($name, $method->getName());
        $this->assertEquals($injectionKeys, $method->getInjectionKeys());
        $this->assertTrue($method->hasInjectionKeys());
        $this->assertEquals($method, new Method($method->__toArray()));

        $newMethod = new Method($method->__toArray());
        $this->assertEquals($method->__toArray(), $newMethod->__toArray());
    }
}
