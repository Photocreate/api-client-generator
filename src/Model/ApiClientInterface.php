<?php

namespace Imunew\Api\Client\Model;

/**
 * Interface ApiClientInterface
 * @package Imunew\Api\Client\Model
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
