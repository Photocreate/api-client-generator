<?php

namespace Photocreate\Api\Client\Generator;

use Twig_Environment;

/**
 * Class PHPGenerator
 * @package Photocreate\Api\Client\Generator
 */
class PHPGenerator extends AbstractGenerator
{
    /**
     * PHPGenerator constructor.
     * @param Twig_Environment $twigEnvironment
     */
    public function __construct(Twig_Environment $twigEnvironment)
    {
        parent::__construct($twigEnvironment, 'php/ApiClient.php.twig');
    }
}
