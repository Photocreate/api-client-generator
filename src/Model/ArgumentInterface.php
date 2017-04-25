<?php

namespace Photocreate\Api\Client\Model;

/**
 * Interface ArgumentInterface
 * @package Photocreate\Api\Client\Model
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
