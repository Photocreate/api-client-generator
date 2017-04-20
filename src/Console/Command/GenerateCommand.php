<?php

namespace Imunew\Api\Client\Console\Command;

use Exception;
use Imunew\Api\Client\Generator\GeneratorInterface;
use Imunew\Api\Client\Linter\LinterInterface;
use Imunew\Api\Client\Parser\ParserInterface;
use InvalidArgumentException;
use Pimple\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateCommand
 * @package Imunew\Api\Client\Console\Command
 */
class GenerateCommand extends Command
{
    /** @var array */
    private static $SUPPORTED_LANGUAGES = ['php'];

    /** @var array */
    private static $FILE_EXTENSIONS = ['php' => '.php'];

    /** @var Container */
    private $container;

    /** @var InputInterface */
    private $input;

    /** @var OutputInterface */
    private $output;

    /** @var string */
    private $language;

    /** @var ParserInterface */
    private $parser;

    /** @var GeneratorInterface */
    private $generator;

    /** @var LinterInterface */
    private $linter;


    /**
     * GenerateCommand constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct('api:client:generate');

        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        parent::configure();

        $this->addOption('spec', 's', InputOption::VALUE_REQUIRED, 'Swagger specification file path.');
        $this->addOption('language', 'l', InputOption::VALUE_OPTIONAL, 'Language.', 'php');
        $this->addOption('output', 'o', InputOption::VALUE_OPTIONAL, 'Output source file path.');
        $this->addOption('class', 'c', InputOption::VALUE_OPTIONAL, 'Class name for API Client.', 'ApiClient');
        $this->addOption('namespace', 'ns', InputOption::VALUE_OPTIONAL, 'Namespace for API Client.', '');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->setUp($input, $output);
            $spec = $this->getSpec($input);
            $apiClient = $this->parser->parse($spec, $this->getParseOptions($input));
            $code = $this->generator->generate($apiClient);
            $isValid = $this->linter->lint($code, $lintResult);
            $output->writeln($lintResult);
            if ($isValid) {
                $this->output($code);
                return 0;
            }
            $this->errorLog($code);
        } catch (Exception $e) {
            $output->writeln([
                $e->getMessage(),
                $e->getTraceAsString()
            ]);
        }

        return -1;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    private function setUp(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $language = $input->getOption('language');
        if (!in_array($language, self::$SUPPORTED_LANGUAGES)) {
            throw new InvalidArgumentException("'{$language}' is invalid language.");
        }
        $this->language = $language;
        $this->generator = $this->container[$this->language. '.generator'];
        $this->linter = $this->container[$this->language. '.linter'];
        $this->parser = $this->container[$this->language. '.parser'];
    }

    /**
     * @param InputInterface $input
     * @return array
     */
    private function getParseOptions(InputInterface $input)
    {
        $className = $input->getOption('class');
        $namespace = $input->getOption('namespace');

        return [
            'className' => $className,
            'namespace' => $namespace
        ];
    }

    /**
     * @param InputInterface $input
     * @return array
     */
    private function getSpec(InputInterface $input)
    {
        $specFile = $input->getOption('spec');
        $jsonString = file_get_contents($specFile);
        if ($jsonString === false) {
            throw new InvalidArgumentException("'{$specFile}' is not exists.");
        }

        return json_decode(file_get_contents($specFile), true);
    }

    /**
     * @param $code
     */
    private function output($code)
    {
        $outputPath = $this->input->getOption('output');
        if (is_dir(dirname($outputPath))) {
            file_put_contents($outputPath, $code);
            $this->output->writeln("{$outputPath} is generated.");
        } else {
            $this->output->writeln($code);
        }
    }

    /**
     * @param $code
     */
    private function errorLog($code)
    {
        $errorPath = './error-api-client'. self::$FILE_EXTENSIONS[$this->language];
        file_put_contents($errorPath, $code);
    }
}
