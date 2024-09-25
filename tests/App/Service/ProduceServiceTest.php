<?php

namespace App\Tests\App\Service;

use App\Entity\Fruit;
use App\Repository\FruitRepository;
use App\Repository\ProductRepositoryInterface;
use App\Service\ProduceService;
use App\Service\ProduceServiceFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ProduceServiceTest extends TestCase
{
    private $produceServiceFactory;
    private $produceService;
    private $mockRepository;

    protected function setUp(): void
    {
        $this->produceServiceFactory = $this->createMock(ProduceServiceFactory::class);
        $this->mockRepository = $this->createMock(ProductRepositoryInterface::class);
        $this->produceService = new ProduceService($this->produceServiceFactory);
    }

    public function testList()
    {
        $type = 'fruit';
        $filters = ['name' => 'apple'];
        $expectedResult = [['id' => 1, 'name' => 'apple', 'weightInGrams' => 150]];

        $request = new Request(['name' => 'apple']);

        $this->produceServiceFactory->expects($this->once())
            ->method('getRepository')
            ->with($type)
            ->willReturn($this->mockRepository);

        $this->mockRepository->expects($this->once())
            ->method('list')
            ->with($filters)
            ->willReturn([new Fruit(1, 'apple', 150)]);

        $result = $this->produceService->list($type, $request);

        $this->assertEquals($expectedResult, $result);
    }

    public function testProcessJsonFile()
    {
        $jsonContent = json_encode([
            ['type' => 'fruit', 'id' => 1, 'name' => 'apple', 'quantity' => 150, 'unit' => 'g'],
            ['type' => 'vegetable', 'id' => 2, 'name' => 'carrot', 'quantity' => 2, 'unit' => 'kg']
        ]);

        $this->produceServiceFactory->expects($this->exactly(2))
            ->method('getRepository')
            ->withConsecutive(['fruit'], ['vegetable'])
            ->willReturn($this->mockRepository);

        $this->mockRepository->expects($this->exactly(2))
            ->method('add')
            ->withConsecutive(
                [1, 'apple', 150],
                [2, 'carrot', 2000]
            );

        $this->produceService->processJsonFile($jsonContent);
    }

    public function testAdd()
    {
        $jsonContent = json_encode([
            'type' => 'fruit',
            'id' => 1,
            'name' => 'apple',
            'quantity' => 150,
            'unit' => 'g'
        ]);

        $request = new Request([], [], [], [], [], [], $jsonContent);

        $this->produceServiceFactory->expects($this->once())
            ->method('getRepository')
            ->with('fruit')
            ->willReturn($this->mockRepository);

        $this->mockRepository->expects($this->once())
            ->method('add')
            ->with(1, 'apple', 150);

        $this->produceService->add($request);
    }

    public function testRemove()
    {
        $type = 'fruit';
        $id = 1;

        $this->produceServiceFactory->expects($this->once())
            ->method('getRepository')
            ->with($type)
            ->willReturn($this->mockRepository);

        $this->mockRepository->expects($this->once())
            ->method('remove')
            ->with($id);

        $this->produceService->remove($type, $id);
    }
}