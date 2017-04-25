<?php

namespace Photocreate\Api\Client\Service\Provider;

use Photocreate\Api\Client\Generator\PHPGenerator;
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
