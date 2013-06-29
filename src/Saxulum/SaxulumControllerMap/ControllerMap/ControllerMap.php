<?php

namespace Saxulum\SaxulumControllerMap\ControllerMap;

class ControllerMap
{
    /**
     * @var Controller[]
     */
    protected $controllers = array();

    public function __construct(array $controllerMap = null)
    {
        if (!is_null($controllerMap)) {
            foreach ($controllerMap['controllers'] as $controllerServiceInfo) {
                $this->addController(new Controller($controllerServiceInfo));
            }
        }
    }

    /**
     * @param Controller $controllerServiceInfo
     * @return $this
     */
    public function addController(Controller $controllerServiceInfo)
    {
        $this->controllers[] = $controllerServiceInfo;

        return $this;
    }

    /**
     * @return Controller[]
     */
    public function getControllers()
    {
        return $this->controllers;
    }

    /**
     * @return array
     */
    public function __toArray()
    {
        $controllerMap = array();
        foreach ($this->getControllers() as $controllerServiceInfo) {
            $controllerMap['controllers'][] = $controllerServiceInfo->__toArray();
        }

        return $controllerMap;
    }
}
