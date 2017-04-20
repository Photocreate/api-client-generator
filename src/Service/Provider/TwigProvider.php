<?php

namespace Imunew\Api\Client\Service\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['twig'] = $pimple->factory(function ($container) {
            $loader = new Twig_Loader_Filesystem($container['twig.template.path']);
            return new Twig_Environment($loader);
        });
    }
}
