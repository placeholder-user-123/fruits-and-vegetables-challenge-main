<?php

namespace App\Traits;


use Doctrine\ORM\QueryBuilder;

trait SearchQueryBuilderTrait
{
    public function searchQueryBuilder(QueryBuilder $query, array $filters): void
    {
        if (isset($filters['name'])) {
            $query->andWhere('e.name LIKE :name')
                ->setParameter('name', '%' . $filters['name'] . '%');
        }

        if (isset($filters['minWeight'])) {
            $query->andWhere('e.weightInGrams >= :minWeight')
                ->setParameter('minWeight', $filters['minWeight']);
        }

        if (isset($filters['maxWeight'])) {
            $query->andWhere('e.weightInGrams <= :maxWeight')
                ->setParameter('maxWeight', $filters['maxWeight']);
        }
    }
}