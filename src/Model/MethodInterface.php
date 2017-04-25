<?php

namespace Photocreate\Api\Client\Model;

/**
 * Interface MethodInterface
 * @package Photocreate\Api\Client\Model
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
