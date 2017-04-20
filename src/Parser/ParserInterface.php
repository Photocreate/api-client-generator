<?php

namespace Imunew\Api\Client\Parser;

use Imunew\Api\Client\Model\ApiClientInterface;

/**
 * Interface ParserInterface
 * @package Imunew\Api\Client\Parser
 */
interface ParserInterface
{
    /**
     * @param $spec
     * @param array $options
     * @return ApiClientInterface
     */
    public function parse($spec, $options = []);
}
