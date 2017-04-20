<?php

namespace Imunew\Api\Client\Linter;

/**
 * Interface LinterInterface
 * @package Imunew\Api\Client\Linter
 */
interface LinterInterface
{
    /**
     * @param string $code
     * @param string $output
     * @return bool true: is valid code, false: is invalid code
     */
    public function lint($code, &$output);
}
