<?php

namespace Photocreate\Api\Client\Parser;

use Photocreate\Api\Client\Model\PHP\ApiClient;
use Photocreate\Api\Client\Model\PHP\Argument;
use Photocreate\Api\Client\Model\PHP\Method;

/**
 * Class PHPParser
 * @package Photocreate\Api\Client\Parser
 */
class PHPParser implements ParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse($spec, $options = [])
    {
        $apiClient = new ApiClient($options['className'], $options['namespace']);
        foreach ($spec['paths'] as $uri => $path) {
            foreach ($path as $http => $operation) {
                $method = $this->parseMethod($spec['basePath']. $uri, $http, $operation);
                if (!empty($method)) {
                    $apiClient->addMethod($method);
                }
            }
        }
        return $apiClient;
    }

    /**
     * @param $uri
     * @param $http
     * @param $operation
     * @return Method
     */
    private function parseMethod($uri, $http, $operation)
    {
        if (!isset($operation['operationId'])) {
            return null;
        }
        $apiMethod = new Method($http, $operation['operationId'], $this->replaceParameterInPath($uri));
        foreach ($operation['parameters'] as $parameter) {
            $type = isset($parameter['type']) ? $parameter['type'] : '';
            $apiMethod->addArgument(new Argument($parameter['name'], $type, $parameter['in']));
        }
        $apiMethod->setRequestContentType($this->guessRequestContentType($http, $operation));
        return $apiMethod;
    }

    private function replaceParameterInPath($path)
    {
        return preg_replace('/\{\s*(\w*)\s*\}/', '{\$$1}', $path);
    }

    private function guessRequestContentType($http, $operation)
    {
        $contentType = null;
        $consumes = isset($operation['consumes']) ? $operation['consumes'] : [];
        $produces = isset($operation['produces']) ? $operation['produces'] : [];
        $contentTypes = array_merge($consumes, $produces);

        if (in_array($http, ['post', 'put', 'patch'])) {
            if (in_array('application/x-www-form-urlencoded', $contentTypes)) {
                $contentType = 'application/x-www-form-urlencoded';
            } elseif (in_array('multipart/form-data', $contentTypes)) {
                $contentType = 'multipart/form-data';
            } elseif (in_array('application/json', $contentTypes)) {
                $contentType = 'application/json';
            }
        }

        return $contentType;
    }
}
