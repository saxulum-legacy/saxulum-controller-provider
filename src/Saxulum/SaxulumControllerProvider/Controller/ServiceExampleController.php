<?php

namespace Saxulum\SaxulumControllerProvider\Controller;

use Silex\Application;

class ServiceExampleController implements ControllerRouteInterface
{
    /**
     * @var array
     */
    protected $testData1;

    /**
     * @var array
     */
    protected $testData2;

    public static function addRoutes(Application $app, $serviceId)
    {
        $app
            ->get('/service', $serviceId . ':indexAction')
            ->bind('service_index')
        ;
    }

    /**
     * @param array $testData
     */
    public function __construct(array $testData)
    {
        $this->testData1 = $testData;
    }

    public function setTestData(array $testData)
    {
        $this->testData2 = $testData;
    }

    public function indexAction()
    {
        return array_key_exists('key1',$this->testData1) && array_key_exists('key1',$this->testData2) ? 'ok': '';
    }
}
