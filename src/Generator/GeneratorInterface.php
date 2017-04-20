<?php

namespace Imunew\Api\Client\Generator;

use Imunew\Api\Client\Model\ApiClientInterface;

/**
 * Interface GeneratorInterface
 * @package Imunew\Api\Client\Generator
 */
interface GeneratorInterface
{
    /**
     * @param ApiClientInterface $apiClient
     * @return string
     */
    public function generate(ApiClientInterface $apiClient);
}
