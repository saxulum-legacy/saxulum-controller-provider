<?php

namespace Saxulum\SaxulumControllerMap\ControllerMap;

class Controller
{
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
     * @return array
     */
    public function hasInjectionKeys()
    {
        return $this->injectionKeys ? true : false;
    }

    /**
     * @param Method $method
     * @return $this
     */
    public function addMethod($method)
    {
        $this->methods[] = $method;

        return $this;
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
