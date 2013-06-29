<?php

namespace Saxulum\SaxulumControllerProvider\Map;

class Map
{
    /**
     * @var Controller[]
     */
    protected $controllers = array();

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
}
