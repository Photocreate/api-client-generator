<?php

$autoloadFiles = [
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../../autoload.php'
];

$autoloader = false;
foreach ($autoloadFiles as $autoloadFile) {
    if (file_exists($autoloadFile)) {
        require_once $autoloadFile;
        $autoloader = true;
    }
}

if (!$autoloader) {
    die('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

use Photocreate\Api\Client\Service\Provider\ConsoleProvider;
use Photocreate\Api\Client\Service\Provider\GeneratorProvider;
use Photocreate\Api\Client\Service\Provider\LinterProvider;
use Photocreate\Api\Client\Service\Provider\ParserProvider;
use Photocreate\Api\Client\Service\Provider\TwigProvider;
use Pimple\Container;
use Symfony\Component\Console\Application;

$composerJson = json_decode(file_get_contents(__DIR__. '/../composer.json'), true);

$container = new Container();
$container['version'] = $composerJson['version'];
$container['twig.template.path'] = realpath(__DIR__. '/../templates');

$container->register(new TwigProvider());
$container->register(new GeneratorProvider());
$container->register(new ParserProvider());
$container->register(new ConsoleProvider());
$container->register(new LinterProvider());

$cli = $container['console.application'];
/** @var Application $cli */
$cli->run();
