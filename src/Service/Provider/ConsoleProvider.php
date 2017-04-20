<?php

namespace Imunew\Api\Client\Service\Provider;

use Imunew\Api\Client\Console\Command\GenerateCommand;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Console\Application;

class ConsoleProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['console.application'] = $pimple->factory(function ($container) {
            $cli = new Application('API Client Generator', $container['version']);
            $cli->addCommands([
                new GenerateCommand($container)
            ]);

            return $cli;
        });
    }
}
