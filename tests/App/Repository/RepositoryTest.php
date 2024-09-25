<?php

namespace App\Tests\App\Repository;

use App\Entity\Fruit;
use App\Repository\FruitRepository;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testAdd(): void
    {
        self::markTestSkipped('This test was only to check if the database works.');
        $this->entityManager->getRepository(Fruit::class)->add($id = 1, $name = 'Apple', $weightInGrams = 100);

        $fruit = $this->entityManager->getRepository(Fruit::class)->find($id);

        $this->assertNotNull($fruit);
        $this->assertEquals($id, $fruit->getId());
        $this->assertEquals($name, $fruit->getName());
        $this->assertEquals($weightInGrams, $fruit->getWeightInGrams());
    }

    public function testList(): void
    {
        self::markTestSkipped('This test was only to check if the database works.');
        $fruits = $this->entityManager->getRepository(Fruit::class)->list(['name' => 'Apple']);
        $this->assertCount(1, $fruits);
    }

    public function testRemove(): void
    {
        self::markTestSkipped('This test was only to check if the database works.');
        $this->entityManager->getRepository(Fruit::class)->remove(1);

        $fruit = $this->entityManager->getRepository(Fruit::class)->find(1);

        $this->assertNull($fruit);
    }

    public function testRemoveThrowsException(): void
    {
        self::markTestSkipped('This test was only to check if the database works.');
        $this->expectException(InvalidArgumentException::class);
        $this->entityManager->getRepository(Fruit::class)->remove(1);
    }


    protected function tearDown(): void
    {
        $this->entityManager->close();
    }
}