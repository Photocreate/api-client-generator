<?php

namespace Example\Petstore;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Petstore
 */
class Petstore
{
    /** @var Client */
    private $httpClient;

    /**
     * ApiClient constructor.
     *
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param  $body
     * @return ResponseInterface
     */
    public function addPet($body)
    {
        $uri = "/v2/pet";

        return $this->httpClient->post($uri, [
            'json' => $body
        ]);
    }

    /**
     * @param  $body
     * @return ResponseInterface
     */
    public function updatePet($body)
    {
        $uri = "/v2/pet";

        return $this->httpClient->put($uri, [
            'json' => $body
        ]);
    }

    /**
     * @param array $status
     * @return ResponseInterface
     */
    public function findPetsByStatus($status)
    {
        $uri = "/v2/pet/findByStatus";

        return $this->httpClient->get($uri, [
            'query' => [
                'status' => $status
            ]
        ]);
    }

    /**
     * @param array $tags
     * @return ResponseInterface
     */
    public function findPetsByTags($tags)
    {
        $uri = "/v2/pet/findByTags";

        return $this->httpClient->get($uri, [
            'query' => [
                'tags' => $tags
            ]
        ]);
    }

    /**
     * @param integer $petId
     * @return ResponseInterface
     */
    public function getPetById($petId)
    {
        $uri = "/v2/pet/{$petId}";

        return $this->httpClient->get($uri, [
        ]);
    }

    /**
     * @param integer $petId
     * @param string $name
     * @param string $status
     * @return ResponseInterface
     */
    public function updatePetWithForm($petId, $name, $status)
    {
        $uri = "/v2/pet/{$petId}";

        return $this->httpClient->post($uri, [
            'form_params' => [
                'name' => $name,
                'status' => $status
            ]
        ]);
    }

    /**
     * @param string $api_key
     * @param integer $petId
     * @return ResponseInterface
     */
    public function deletePet($api_key, $petId)
    {
        $uri = "/v2/pet/{$petId}";

        return $this->httpClient->delete($uri, [
            'headers' => [
                'api_key' => $api_key
            ]
        ]);
    }

    /**
     * @param integer $petId
     * @param string $additionalMetadata
     * @param file $file
     * @return ResponseInterface
     */
    public function uploadFile($petId, $additionalMetadata, $file)
    {
        $uri = "/v2/pet/{$petId}/uploadImage";

        return $this->httpClient->post($uri, [
            'multipart' => [
                [
                    'name' => 'additionalMetadata',
                    'contents' => $additionalMetadata
                ],
                [
                    'name' => 'file',
                    'contents' => fopen($file, 'r')
                ]
            ]
        ]);
    }

    /**
     * @return ResponseInterface
     */
    public function getInventory()
    {
        $uri = "/v2/store/inventory";

        return $this->httpClient->get($uri, [
        ]);
    }

    /**
     * @param  $body
     * @return ResponseInterface
     */
    public function placeOrder($body)
    {
        $uri = "/v2/store/order";

        return $this->httpClient->post($uri, [
            'json' => $body
        ]);
    }

    /**
     * @param integer $orderId
     * @return ResponseInterface
     */
    public function getOrderById($orderId)
    {
        $uri = "/v2/store/order/{$orderId}";

        return $this->httpClient->get($uri, [
        ]);
    }

    /**
     * @param integer $orderId
     * @return ResponseInterface
     */
    public function deleteOrder($orderId)
    {
        $uri = "/v2/store/order/{$orderId}";

        return $this->httpClient->delete($uri, [
        ]);
    }

    /**
     * @param  $body
     * @return ResponseInterface
     */
    public function createUser($body)
    {
        $uri = "/v2/user";

        return $this->httpClient->post($uri, [
            'json' => $body
        ]);
    }

    /**
     * @param  $body
     * @return ResponseInterface
     */
    public function createUsersWithArrayInput($body)
    {
        $uri = "/v2/user/createWithArray";

        return $this->httpClient->post($uri, [
            'json' => $body
        ]);
    }

    /**
     * @param  $body
     * @return ResponseInterface
     */
    public function createUsersWithListInput($body)
    {
        $uri = "/v2/user/createWithList";

        return $this->httpClient->post($uri, [
            'json' => $body
        ]);
    }

    /**
     * @param string $username
     * @param string $password
     * @return ResponseInterface
     */
    public function loginUser($username, $password)
    {
        $uri = "/v2/user/login";

        return $this->httpClient->get($uri, [
            'query' => [
                'username' => $username,
                'password' => $password
            ]
        ]);
    }

    /**
     * @return ResponseInterface
     */
    public function logoutUser()
    {
        $uri = "/v2/user/logout";

        return $this->httpClient->get($uri, [
        ]);
    }

    /**
     * @param string $username
     * @return ResponseInterface
     */
    public function getUserByName($username)
    {
        $uri = "/v2/user/{$username}";

        return $this->httpClient->get($uri, [
        ]);
    }

    /**
     * @param string $username
     * @param  $body
     * @return ResponseInterface
     */
    public function updateUser($username, $body)
    {
        $uri = "/v2/user/{$username}";

        return $this->httpClient->put($uri, [
            'json' => $body
        ]);
    }

    /**
     * @param string $username
     * @return ResponseInterface
     */
    public function deleteUser($username)
    {
        $uri = "/v2/user/{$username}";

        return $this->httpClient->delete($uri, [
        ]);
    }

}
