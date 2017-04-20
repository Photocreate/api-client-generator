<?php

namespace Imunew\Api\Client\Model;

/**
 * Interface ArgumentInterface
 * @package Imunew\Api\Client\Model
 */
interface ArgumentInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getLocation();
}
