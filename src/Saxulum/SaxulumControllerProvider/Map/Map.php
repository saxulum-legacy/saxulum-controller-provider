<?php

namespace Saxulum\SaxulumControllerProvider\Map;

class Map
{
    /**
     * @var Controller[]
     */
    protected $controllers = array();

    /**
     * @param  Controller $controllerServiceInfo
     * @param  bool       $stopPropagation
     * @return Controller
     */
    public function addController(Controller $controllerServiceInfo, $stopPropagation = false)
    {
        $this->controllers[] = $controllerServiceInfo;
        if (!$stopPropagation) {
            $controllerServiceInfo->setMap($this, true);
        }

        return $controllerServiceInfo;
    }

    /**
     * @return Controller[]
     */
    public function getControllers()
    {
        return $this->controllers;
    }
}
