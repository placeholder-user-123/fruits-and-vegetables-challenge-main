<?php

namespace App\Repository;

use App\Entity\Fruit;
use App\Traits\SearchQueryBuilderTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use InvalidArgumentException;

class FruitRepository extends EntityRepository implements ProductRepositoryInterface
{
    use SearchQueryBuilderTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Fruit::class));
    }

    public function add(int $id, string $name, int $weightInGrams)
    {
        $fruit = new Fruit(id: $id, name: $name, weightInGrams: $weightInGrams);
        $this->entityManager->persist($fruit);
        $this->entityManager->flush();
    }

    public function remove(int $id)
    {
        $fruit = $this->entityManager->find(Fruit::class, $id);
        if (!$fruit) {
            throw new InvalidArgumentException('Fruit not found.');
        }
        $this->entityManager->remove($fruit);
        $this->entityManager->flush();
    }

    public function list(array $filters): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('e')
            ->from(Fruit::class, 'e');

        $this->searchQueryBuilder($queryBuilder, $filters);

        return $queryBuilder->getQuery()->getResult();
    }
}