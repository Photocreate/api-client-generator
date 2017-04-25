<?php

namespace Photocreate\Api\Client\Service\Provider;

use Photocreate\Api\Client\Linter\PHPLinter;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class LinterProvider
 * @package Photocreate\Api\Client\Service\Provider
 */
class LinterProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['php.linter'] = $pimple->factory(function ($container) {
            return new PHPLinter();
        });
    }
}
