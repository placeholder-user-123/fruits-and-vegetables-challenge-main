<?php

namespace App\Repository;

use App\Entity\Vegetable;
use App\Traits\SearchQueryBuilderTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use InvalidArgumentException;

class VegetableRepository extends EntityRepository implements ProductRepositoryInterface
{
    use SearchQueryBuilderTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Vegetable::class));
    }

    public function add(int $id, string $name, int $weightInGrams)
    {
        $vegetable = new Vegetable(id: $id, name: $name, weightInGrams: $weightInGrams);
        $this->entityManager->persist($vegetable);
        $this->entityManager->flush();
    }

    public function remove(int $id)
    {
        $vegetable = $this->entityManager->find(Vegetable::class, $id);
        if (!$vegetable) {
            throw new InvalidArgumentException('Vegetable not found.');
        }
        $this->entityManager->remove($vegetable);
        $this->entityManager->flush();
    }

    public function list(array $filters): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('e')
            ->from(Vegetable::class, 'e');

        $this->searchQueryBuilder($queryBuilder, $filters);

        return $queryBuilder->getQuery()->getResult();
    }
}