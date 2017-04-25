<?php

namespace Photocreate\Api\Client\Console\Command;

use Photocreate\Api\Client\Service\Provider\ConsoleProvider;
use Photocreate\Api\Client\Service\Provider\GeneratorProvider;
use Photocreate\Api\Client\Service\Provider\LinterProvider;
use Photocreate\Api\Client\Service\Provider\ParserProvider;
use Photocreate\Api\Client\Service\Provider\TwigProvider;
use PHPUnit\Framework\TestCase;
use Pimple\Container;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateCommandTest extends TestCase
{
    public function getApplication()
    {
        $composerJson = json_decode(file_get_contents(__DIR__. '/../../../composer.json'), true);

        $container = new Container();
        $container['version'] = $composerJson['version'];
        $container['twig.template.path'] = realpath(__DIR__. '/../../../templates');

        $container->register(new TwigProvider());
        $container->register(new GeneratorProvider());
        $container->register(new ParserProvider());
        $container->register(new ConsoleProvider());
        $container->register(new LinterProvider());

        return $container['console.application'];
    }

    /**
     * @test
     * @dataProvider getTestData
     */
    public function generate($options, $isSuccess, $messages)
    {
        $application = $this->getApplication();
        /** @var Application $application */

        $command = $application->find('api:client:generate');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            '--spec' => $options['spec'],
            '--language' => $options['language'],
            '--class' => $options['class'],
            '--namespace' => $options['namespace']
        ]);

        $output = $commandTester->getDisplay();

        if ($isSuccess) {
            $this->assertSame(0, $commandTester->getStatusCode());
            $this->assertContains("class {$options['class']}", $output);
            $this->assertContains("namespace {$options['namespace']}", $output);
        } else {
            $this->assertNotSame(0, $commandTester->getStatusCode());
        }

        foreach ($messages as $message) {
            $this->assertContains($message, $output);
        }
    }

    public function getTestData()
    {
        return [
            [
                'options' => [
                    'class' => 'Petstore',
                    'namespace' => 'Example\Petstore',
                    'spec' => 'http://localhost:8002/v2/swagger.json',
                    'language' => 'php'
                ],
                'isSuccess' => true,
                'messages' => [
                    'No syntax errors detected'
                ]
            ],
            [
                'options' => [
                    'class' => 'Pet..store',
                    'namespace' => 'Example\Petstore',
                    'spec' => 'http://localhost:8002/v2/swagger.json',
                    'language' => 'php'
                ],
                'isSuccess' => false,
                'messages' => [
                    'Parse error'
                ]
            ],
            [
                'options' => [
                    'class' => 'Petstore',
                    'namespace' => 'Example\Petstore',
                    'spec' => '/missing/path/to/swagger.json',
                    'language' => 'php'
                ],
                'isSuccess' => false,
                'messages' => [
                    'No such file or directory'
                ]
            ],
            [
                'options' => [
                    'class' => 'Petstore',
                    'namespace' => 'Example\Petstore',
                    'spec' => 'http://localhost:8002/v2/swagger.json',
                    'language' => 'go'
                ],
                'isSuccess' => false,
                'messages' => [
                    'is invalid language'
                ]
            ],
        ];
    }

}