<?php

namespace Saxulum\SaxulumControllerProvider\Map;

class Controller
{
    /**
     * @var Map
     */
    protected $map;

    /**
     * @var string
     */
    protected $serviceId;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var bool
     */
    protected $injectContainer = false;

    /**
     * @var array
     */
    protected $injectionKeys = array();

    /**
     * @var Method[]
     */
    protected $methods = array();

    /**
     * @param array $controllerInfo
     */
    public function __construct(array $controllerInfo = null)
    {
        if (!is_null($controllerInfo)) {
            $this->setServiceId($controllerInfo['serviceId']);
            $this->setNamespace($controllerInfo['namespace']);
            $this->setInjectContainer($controllerInfo['injectContainer']);
            $this->setInjectionKeys($controllerInfo['injectionKeys']);
            foreach ($controllerInfo['methods'] as $methodInfo) {
                $this->addMethod(new Method($methodInfo));
            }
        }
    }

    /**
     * @param Map  $map
     * @param bool $stopPropagation
     * @return $this
     */
    public function setMap(Map $map, $stopPropagation = false)
    {
        if (!$stopPropagation) {
            $map->addController($this, true);
        }
        $this->map = $map;

        return $this;
    }

    /**
     * @return Map
     */
    public function end()
    {
        return $this->map;
    }

    /**
     * @param $serviceId
     * @return $this
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;

        return $this;
    }

    /**
     * @return string
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * @param string $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param boolean $injectContainer
     * @return $this
     */
    public function setInjectContainer($injectContainer)
    {
        $this->injectContainer = $injectContainer;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isInjectContainer()
    {
        return $this->injectContainer;
    }

    /**
     * @param array $injectionKeys
     * @return $this
     */
    public function setInjectionKeys($injectionKeys)
    {
        $this->injectionKeys = $injectionKeys;

        return $this;
    }

    /**
     * @return array
     */
    public function getInjectionKeys()
    {
        return $this->injectionKeys;
    }

    /**
     * @return bool
     */
    public function hasInjectionKeys()
    {
        return $this->injectionKeys ? true : false;
    }

    /**
     * @param  Method $method
     * @param  bool   $stopPropagation
     * @return Method
     */
    public function addMethod(Method $method, $stopPropagation = false)
    {
        $this->methods[] = $method;
        if (!$stopPropagation) {
            $method->setController($this, true);
        }

        return $method;
    }

    /**
     * @return Method[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @return bool
     */
    public function hasMethods()
    {
        return $this->methods ? true : false;
    }

    /**
     * @return array
     */
    public function __toArray()
    {
        $controllerInfo = array();
        $controllerInfo['serviceId'] = $this->getServiceId();
        $controllerInfo['namespace'] = $this->getNamespace();
        $controllerInfo['injectContainer'] = $this->isInjectContainer();
        $controllerInfo['injectionKeys'] = $this->getInjectionKeys();
        $controllerInfo['methods'] = array();
        foreach ($this->getMethods() as $method) {
            $controllerInfo['methods'][] = $method->__toArray();
        }

        return $controllerInfo;
    }
}
