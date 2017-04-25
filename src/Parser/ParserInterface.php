<?php

namespace Photocreate\Api\Client\Parser;

use Photocreate\Api\Client\Model\ApiClientInterface;

/**
 * Interface ParserInterface
 * @package Photocreate\Api\Client\Parser
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
