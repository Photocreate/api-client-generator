<?php

namespace Photocreate\Api\Client\Model\PHP;

use Photocreate\Api\Client\Model\ApiClientInterface;
use Photocreate\Api\Client\Model\MethodInterface;

/**
 * Class ApiClient
 * @package Photocreate\Api\Client\Model\PHP
 */
class ApiClient implements ApiClientInterface
{
    /** @var string */
    private $className;

    /** @var string */
    private $namespace;

    /** @var Method[] */
    private $methods;

    /**
     * ApiClient constructor.
     * @param string $className
     * @param null $namespace
     */
    public function __construct($className = 'ApiClient', $namespace = null)
    {
        $this->className = $className;
        $this->namespace = $namespace;
        $this->methods = [];
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * {@inheritdoc}
     */
    public function addMethod(MethodInterface $method)
    {
        $this->methods[] = $method;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethods()
    {
        return $this->methods;
    }
}
