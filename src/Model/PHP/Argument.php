<?php

namespace Photocreate\Api\Client\Model\PHP;

use Photocreate\Api\Client\Model\ArgumentInterface;

/**
 * Class Argument
 * @package Photocreate\Api\Client\Model\PHP
 */
class Argument implements ArgumentInterface
{
    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /**
     * @see http://swagger.io/specification/#parameterObject
     * @var string
     */
    private $location;

    /**
     * Argument constructor.
     * @param $name
     * @param $type
     * @param $location
     */
    public function __construct($name, $type, $location)
    {
        $this->name = $name;
        $this->type = $type;
        $this->location = $location;
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
    public function getVariable()
    {
        return '$'. $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
}
