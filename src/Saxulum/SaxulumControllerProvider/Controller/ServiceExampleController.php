<?php

namespace Saxulum\SaxulumControllerProvider\Controller;

use Silex\Application;

class ServiceExampleController implements ControllerRouteInterface
{
    /**
     * @var array
     */
    protected $testData;

    /**
     * @var array
     */
    protected $testData1;

    /**
     * @var array
     */
    protected $testData2;

    /**
     * @param Application $app
     * @param string      $serviceId
     */
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
        $this->testData = $testData;
    }

    /**
     * @param array $testData1
     */
    public function setTestData1(array $testData1)
    {
        $this->testData1 = $testData1;
    }

    /**
     * @param array $testData2
     */
    public function setTestData2(array $testData2)
    {
        $this->testData2 = $testData2;
    }

    public function indexAction()
    {
        if(array_key_exists('key1', $this->testData) &&
           array_key_exists('key1', $this->testData1) &&
           array_key_exists('key1', $this->testData2)) {
            return 'ok';
        }

        return 'failed';
    }
}
