<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class ProduceService
{
    public function __construct(private ProduceServiceFactory $produceServiceFactory)
    {
    }

    public function list(string $type, Request $request): array
    {
        $filters = $request->query->all();

        $results = $this->produceServiceFactory
            ->getRepository($type)
            ->list($filters);
        return array_map(function ($item) {
            $result = $item->toArray();
            if (isset($filters['unit']) && $filters['unit'] === 'kg') {
                $result['weightInKg'] = $item['weightInGrams'] / 1000;

                return $result;
            }

            return $result;
        }, $results);
    }

    public function processJsonFile(string $jsonContent): void
    {
        $data = json_decode($jsonContent, true);
        foreach ($data as $item) {
            $this->produceServiceFactory
                ->getRepository($item['type'])
                ->add($item['id'], $item['name'], $this->getWeightInGrams($item));
        }
    }

    public function add(Request $request): void
    {
        $item = json_decode($request->getContent(), true);
        $this->produceServiceFactory
            ->getRepository($item['type'])
            ->add(id: $item['id'], name: $item['name'], weightInGrams: $this->getWeightInGrams($item));
    }

    private function getWeightInGrams(array $item): int
    {
        if ($item['unit'] === 'kg') {
            return $item['quantity'] * 1000;
        }
        return $item['quantity'];
    }

    public function remove(string $type, int $id): void
    {
        $this->produceServiceFactory
            ->getRepository($type)
            ->remove($id);
    }
}