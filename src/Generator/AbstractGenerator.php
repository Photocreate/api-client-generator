<?php

namespace Imunew\Api\Client\Generator;

use Imunew\Api\Client\Model\ApiClientInterface;
use Twig_Environment;

/**
 * Class AbstractGenerator
 * @package Imunew\Api\Client\Generator
 */
abstract class AbstractGenerator implements GeneratorInterface
{
    /** @var Twig_Environment */
    private $twigEnvironment;

    /** @var string */
    private $templatePath;

    /**
     * AbstractGenerator constructor.
     * @param Twig_Environment $twigEnvironment
     * @param string $templatePath
     */
    public function __construct(Twig_Environment $twigEnvironment, $templatePath)
    {
        $this->twigEnvironment = $twigEnvironment;
        $this->templatePath = $templatePath;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(ApiClientInterface $apiClient)
    {
        $template = $this->twigEnvironment->load($this->templatePath);
        return $template->render(['api' => $apiClient]);
    }
}
