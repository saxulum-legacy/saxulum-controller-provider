<?php

namespace Saxulum\SaxulumControllerProvider\Map;

class Map
{
    /**
     * @var Controller[]
     */
    protected $controllers = array();

    /**
     * @param  Controller $controller
     * @param  bool       $stopPropagation
     * @return Controller
     */
    public function addController(Controller $controller = null, $stopPropagation = false)
    {
        if (is_null($controller)) {
            $controller = new Controller();
        }

        if (!$stopPropagation) {
            $controller->setMap($this, true);
        }

        $this->controllers[] = $controller;

        return $controller;
    }

    /**
     * @return Controller[]
     */
    public function getControllers()
    {
        return $this->controllers;
    }
}
