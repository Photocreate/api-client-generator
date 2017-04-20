<?php

namespace Imunew\Api\Client\Service\Provider;

use Imunew\Api\Client\Generator\PHPGenerator;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class GeneratorProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['php.generator'] = $pimple->factory(function ($container) {
            return new PHPGenerator($container['twig']);
        });
    }
}
