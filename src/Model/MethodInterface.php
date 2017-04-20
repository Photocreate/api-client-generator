<?php

namespace Imunew\Api\Client\Model;

/**
 * Interface MethodInterface
 * @package Imunew\Api\Client\Model
 */
interface MethodInterface
{
    /**
     * @param ArgumentInterface $argument
     */
    public function addArgument(ArgumentInterface $argument);

    /**
     * @return ArgumentInterface[]
     */
    public function getArguments();
}
