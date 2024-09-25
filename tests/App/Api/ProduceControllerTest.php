<?php

namespace App\Tests\App\Api;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProduceControllerTest extends WebTestCase
{
    private ?EntityManagerInterface $entityManager;

    public function testProcessJson()
    {
        $client = static::createClient();
        $jsonContent = json_encode([
            [
                "id" => 1,
                "name" => "Carrot",
                "type" => "vegetable",
                "quantity" => 10922,
                "unit" => "g"
            ],
            [
                "id" => 2,
                "name" => "Apples",
                "type" => "fruit",
                "quantity" => 20,
                "unit" => "kg"
            ]
        ]);

        $client->request('POST', '/api/process', [], [], [], $jsonContent);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'JSON processed successfully']),
            $client->getResponse()->getContent()
        );
    }

    public function testAddFruit()
    {
        $client = static::createClient();
        $fruitData = json_encode([
            "id" => 3,
            "name" => "Bananas",
            "type" => "fruit",
            "quantity" => 100,
            "unit" => "kg"
        ]);

        $client->request(
            'POST',
            '/api/fruit',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $fruitData
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Fruit added successfully']),
            $client->getResponse()->getContent()
        );
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testItFailsAddingItemWIthInvalidData($data, $expectedErrors)
    {
        $client = static::createClient();
        $fruitData = json_encode($data);

        $client->request(
            'POST',
            '/api/fruit',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $fruitData
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['errors' => $expectedErrors]),
            $client->getResponse()->getContent()
        );
    }

    protected function invalidDataProvider(): array
    {
        return [
            'Wrong Unit' => [
                [
                    "id" => 3,
                    "name" => "Milk",
                    "type" => "fruit",
                    "quantity" => 100,
                    "unit" => "ml"
                ],
                ['unit' => 'Unit must be either \'g\' or \'kg\'']
            ],
            'Blank Attributes' => [
                [],
                [
                    'id' => 'This value should not be blank.',
                    'name' => 'This value should not be blank.',
                    'quantity' => 'This value should not be blank.',
                    'unit' => 'This value should not be blank.',
                    'type' => 'This value should not be blank.'
                ]
            ],
            'Invalid data' => [
                [
                    "id" => 3,
                    "name" => "Bananas",
                    "type" => "fruit",
                    "quantity" => 0,
                    "unit" => "kg"
                ],
                ['quantity' => 'This value should be greater than 0.']
            ],
            'Invalid type' => [
                [
                    "id" => 3,
                    "name" => "parmesan",
                    "type" => "cheese",
                    "quantity" => 1,
                    "unit" => "kg"
                ],
                ['type' => 'Type must be either \'vegetable\' or \'fruit\'']
            ],

        ];
    }

    public function testAddVegetable()
    {
        $client = static::createClient();
        $vegetableData = json_encode([
            "id" => 4,
            "name" => "Pepper",
            "type" => "vegetable",
            "quantity" => 150,
            "unit" => "kg"
        ]);

        $client->request(
            'POST',
            '/api/vegetable',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $vegetableData
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Vegetable added successfully']),
            $client->getResponse()->getContent()
        );
    }

    public function testRemoveFruit()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/fruit',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                "id" => 2,
                "name" => "kiwi",
                "type" => "fruit",
                "quantity" => 10922,
                "unit" => "g"
            ])
        );

        $client->request('DELETE', '/api/fruits/2'); // Testing removal of "Apples" with ID 2

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Fruit removed successfully']),
            $client->getResponse()->getContent()
        );
    }

    public function testRemoveVegetable()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/fruit',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                "id" => 1,
                "name" => "Carrot",
                "type" => "vegetable",
                "quantity" => 10922,
                "unit" => "g"
            ])
        );

        $client->request('DELETE', '/api/vegetables/1'); // Testing removal of "Carrot" with ID 1

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Vegetable removed successfully']),
            $client->getResponse()->getContent()
        );
    }

    /**
     * @dataProvider invalidRemoveDataProvider
     */
    public function testInvalidRemove(string $url, $expectedMessage)
    {
        $client = static::createClient();
        $client->request('DELETE', $url);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => $expectedMessage]),
            $client->getResponse()->getContent()
        );
    }

    protected function invalidRemoveDataProvider(): array
    {
        return [
            'Non-existent fruit' => [
                '/api/fruits/100000',
                'Fruit not found.'
            ],
            'Non-existent vegetable' => [
                '/api/vegetables/10000',
                'Vegetable not found.'
            ]
        ];
    }

    public function testListFruits()
    {

        $client = static::createClient();
        $client->request('POST', '/api/process', [], [], [], file_get_contents('request.json'));
        $client->request('GET', '/api/fruits');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertCount(10 , json_decode($client->getResponse()->getContent()));
    }

    public function testListVegetables()
    {
        $client = static::createClient();
        $client->request('POST', '/api/process', [], [], [], file_get_contents('request.json'));
        $client->request('GET', '/api/vegetables');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertCount(10 , json_decode($client->getResponse()->getContent()));
    }

    /**
     * @dataProvider searchDataProvider
     */
    public function testSearch($query, $expectedCount)
    {
        $client = static::createClient();
        $client->request('POST', '/api/process', [], [], [], file_get_contents('request.json'));
        $client->request('GET', '/api/fruits?' . $query);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertCount($expectedCount , json_decode($client->getResponse()->getContent()));
    }

    protected function searchDataProvider()
    {
        return [
            'Search for apple' => [
                'name=apple',
                1
            ],
            'Search for fruits that has alphabet k' => [
                'name=k',
                2
            ],
            'Search for min Weight' => [
                'minWeight=100',
                10
            ],
            'Search for max Weight' => [
                'maxWeight=24000',
                7
            ],
        ];
    }

    protected function tearDown(): void
    {
        //todo: this should be done in a better way

        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $connection = $this->entityManager->getConnection();
        $schemaManager = $connection->createSchemaManager();

        $connection->executeQuery('SET FOREIGN_KEY_CHECKS=0');

        $tables = $schemaManager->listTableNames();
        foreach ($tables as $table) {
            $connection->executeStatement('TRUNCATE TABLE ' . $table);
        }

        $connection->executeQuery('SET FOREIGN_KEY_CHECKS=1');

        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}