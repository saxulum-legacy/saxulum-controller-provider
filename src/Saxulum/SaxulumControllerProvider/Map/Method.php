<?php

namespace Saxulum\SaxulumControllerProvider\Map;

class Method
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $injectionKeys = array();

    /**
     * @param array $methodInjectionInfo
     */
    public function __construct(array $methodInjectionInfo = null)
    {
        if (!is_null($methodInjectionInfo)) {
            $this->setName($methodInjectionInfo['name']);
            $this->setInjectionKeys($methodInjectionInfo['injectionKeys']);
        }
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @return array
     */
    public function __toArray()
    {
        $methodInjectionInfo = array();
        $methodInjectionInfo['name'] = $this->getName();
        $methodInjectionInfo['injectionKeys'] = $this->getInjectionKeys();

        return $methodInjectionInfo;
    }
}
