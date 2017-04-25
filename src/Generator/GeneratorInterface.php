<?php

namespace Photocreate\Api\Client\Generator;

use Photocreate\Api\Client\Model\ApiClientInterface;

/**
 * Interface GeneratorInterface
 * @package Photocreate\Api\Client\Generator
 */
interface GeneratorInterface
{
    /**
     * @param ApiClientInterface $apiClient
     * @return string
     */
    public function generate(ApiClientInterface $apiClient);
}
