<?php

namespace Photocreate\Api\Client\Service\Provider;

use Photocreate\Api\Client\Parser\PHPParser;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ParserProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['php.parser'] = $pimple->factory(function ($container) {
            return new PHPParser();
        });
    }
}
