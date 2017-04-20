<?php

require_once 'Petstore.php';

use Example\Petstore\Petstore;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;


class PetstoreTest extends TestCase
{
    /** @var Petstore */
    private $apiClient;

    /** @var int */
    private static $lastPatId;

    /**
     * @return void
     */
    protected function setUp()
    {
        $httpClient = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8002',
        ]);

        $this->apiClient = new Petstore($httpClient);
    }

    /**
     * @test
     */
    public function addPet()
    {
        $body = [
            'id' => 0,
            'category' => [
                'id' => 0,
                'name' => 'string'
            ],
            'name' => 'doggie',
            'photoUrls' => [
                'string'
            ],
            'tags' => [[
                'id' => 0,
                'name' => 'string'
            ]],
            'status' => 'available'
        ];

        $response = $this->apiClient->addPet($body);
        $this->assertSame($response->getStatusCode(), 200);
        $contents = json_decode($response->getBody()->getContents(), true);
        $this->assertGreaterThan(0, (int)$contents['id']);
        self::$lastPatId = (int)$contents['id'];
    }

    /**
     * @test
     */
    public function updatePet()
    {
        $petId = self::$lastPatId;
        $pet = $this->apiClient->getPetById($petId);
        $body = json_decode($pet->getBody()->getContents(), true);
        $body['name'] = 'updated '. $petId;

        $response = $this->apiClient->updatePet($body);
        $this->assertSame($response->getStatusCode(), 200);
        $contents = json_decode($response->getBody()->getContents(), true);
        $this->assertSame($petId, $contents['id']);
    }

    /**
     * @test
     */
    public function findPetsByStatus()
    {
        $response = $this->apiClient->findPetsByStatus('available');
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertNotEmpty($response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function findPetsByTags()
    {
        $response = $this->apiClient->findPetsByTags('tag1');
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertNotEmpty($response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function getPetById()
    {
        $response = $this->apiClient->getPetById(1);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertNotEmpty($response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function updatePetWithForm()
    {
        $response = $this->apiClient->updatePetWithForm(1, 'cat', 'available');
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function deletePet()
    {
        $response = $this->apiClient->deletePet('special-key', self::$lastPatId);
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function uploadFile()
    {
        $response = $this->apiClient->uploadFile(8, '', __DIR__. '/dog.jpg');
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function getInventory()
    {
        $response = $this->apiClient->getInventory();
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function placeOrder()
    {
        $body = [
            'id' => 10,
            'petId' => 1,
            'quantity' => 1,
            'shipDate' => '2017-04-04T04:29:21.692Z',
            'status' => 'placed',
            'complete' => false
        ];

        $response = $this->apiClient->placeOrder($body);
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function getOrderById()
    {
        $response = $this->apiClient->getOrderById(1);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertNotEmpty($response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function deleteOrder()
    {
        try {
            $response = $this->apiClient->deleteOrder(10);
            $this->assertSame($response->getStatusCode(), 200);
        } catch (ClientException $e) {
            $this->assertSame($e->getResponse()->getStatusCode(), 404);
        }
    }

    /**
     * @test
     */
    public function createUser()
    {
        $body = [
            'id' => 12,
            'username' => 'user12',
            'firstName' => 'first name 12',
            'lastName' => 'last name 12',
            'email' => 'email12@test.com',
            'password' => 'password',
            'phone' => '123-456-7890',
            'userStatus' => 1
        ];

        $response = $this->apiClient->createUser($body);
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function createUsersWithArrayInput()
    {
        $json = [[
            'id' => 13,
            'username' => 'user13',
            'firstName' => 'first name 13',
            'lastName' => 'last name 13',
            'email' => 'email13@test.com',
            'password' => 'password',
            'phone' => '123-456-7890',
            'userStatus' => 1
        ]];

        $response = $this->apiClient->createUsersWithArrayInput($json);
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function createUsersWithListInput()
    {
        $json = [[
            'id' => 14,
            'username' => 'user14',
            'firstName' => 'first name 14',
            'lastName' => 'last name 14',
            'email' => 'email14@test.com',
            'password' => 'password',
            'phone' => '123-456-7890',
            'userStatus' => 1
        ]];

        $response = $this->apiClient->createUsersWithListInput($json);
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function loginUser()
    {
        $username = 'username';
        $password = 'password';

        $response = $this->apiClient->loginUser($username, $password);
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function logoutUser()
    {
        $response = $this->apiClient->logoutUser();
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function getUserByName()
    {
        $username = 'user10';

        $response = $this->apiClient->getUserByName($username);
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function updateUser()
    {
        $response = $this->apiClient->getUserByName('user10');
        $body = json_decode($response->getBody()->getContents(), true);
        $body['firstName'] = 'first-name-10';

        $response = $this->apiClient->updateUser('user10', $body);
        $this->assertSame($response->getStatusCode(), 200);
    }

    /**
     * @test
     */
    public function deleteUser()
    {
        $response = $this->apiClient->deleteUser('user14');
        $this->assertSame($response->getStatusCode(), 200);
    }

}
