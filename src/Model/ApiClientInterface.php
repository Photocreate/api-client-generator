<?php

namespace Photocreate\Api\Client\Model;

/**
 * Interface ApiClientInterface
 * @package Photocreate\Api\Client\Model
 */
interface ApiClientInterface
{
    /**
     * @param MethodInterface $method
     */
    public function addMethod(MethodInterface $method);

    /**
     * @return MethodInterface[]
     */
    public function getMethods();
}
