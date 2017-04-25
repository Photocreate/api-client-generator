<?php

namespace Photocreate\Api\Client\Model\PHP;

use Photocreate\Api\Client\Model\ArgumentInterface;
use Photocreate\Api\Client\Model\MethodInterface;

/**
 * Class Method
 * @package Photocreate\Api\Client\Model\PHP
 */
class Method implements MethodInterface
{
    /** @var string */
    private $httpMethod;

    /** @var string */
    private $name;

    /** @var string */
    private $uri;

    /** @var Argument[] */
    private $arguments;

    /** @var string */
    private $requestContentType;

    /**
     * Method constructor.
     * @param $httpMethod
     * @param $name
     * @param $uri
     */
    public function __construct($httpMethod, $name, $uri)
    {
        $this->httpMethod = $httpMethod;
        $this->name = $name;
        $this->uri = $uri;
        $this->arguments = [];
    }

    /**
     * {@inheritdoc}
     */
    public function addArgument(ArgumentInterface $argument)
    {
        $this->arguments[] = $argument;
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param string[] $excludeLocations
     * @return Argument[]
     */
    public function getArgumentsWithout(array $excludeLocations)
    {
        $arguments = [];
        foreach ($this->arguments as $argument) {
            if (in_array($argument->getLocation(), $excludeLocations)) {
                continue;
            }
            $arguments[] = $argument;
        }
        return $arguments;
    }

    /**
     * @param string[] $includeLocations
     * @return Argument[]
     */
    public function getArgumentsWith(array $includeLocations)
    {
        $arguments = [];
        foreach ($this->arguments as $argument) {
            if (in_array($argument->getLocation(), $includeLocations)) {
                $arguments[] = $argument;
            }
        }
        return $arguments;
    }

    /**
     * @return string[]
     */
    public function getVariables()
    {
        return array_map(function ($argument) {
            return $argument->getVariable();
        }, $this->arguments);
    }

    /**
     * @param $requestContentType
     */
    public function setRequestContentType($requestContentType)
    {
        $this->requestContentType = $requestContentType;
    }

    /**
     * @return string
     */
    public function getRequestContentType()
    {
        return $this->requestContentType;
    }

    /**
     * @see http://docs.guzzlephp.org/en/latest/request-options.html
     * @return string
     */
    public function getGuzzleRequestOption()
    {
        $guzzleRequestOptions = [
            'application/x-www-form-urlencoded' => 'form_params',
            'application/json' => 'json',
            'multipart/form-data' => 'multipart'
        ];

        if (array_key_exists($this->requestContentType, $guzzleRequestOptions)) {
            return $guzzleRequestOptions[$this->requestContentType];
        }

        return 'body';
    }

    /**
     * @return bool
     * @see http://swagger.io/specification/#parameterObject
     * <quote>
     * Body - The payload that's appended to the HTTP request. Since there can only be one payload, there can only be one body parameter.
     * The name of the body parameter has no effect on the parameter itself and is used for documentation purposes only.
     * Since Form parameters are also in the payload, body and form parameters cannot exist together for the same operation.
     * </quote>
     */
    public function hasBodyOnly()
    {
        $arguments = $this->getArgumentsWithout(['path']);
        if (empty($arguments)) {
            return false;
        }
        $argument = reset($arguments);
        return ($argument->getLocation() === 'body');
    }

    /**
     * @return Argument|null
     */
    public function getFirstArgumentWithoutPath()
    {
        $arguments = $this->getArgumentsWithout(['path']);
        if (empty($arguments)) {
            return null;
        }
        return reset($arguments);
    }
}
