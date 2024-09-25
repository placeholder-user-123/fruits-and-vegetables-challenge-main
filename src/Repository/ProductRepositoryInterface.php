<?php

namespace App\Repository;

interface ProductRepositoryInterface
{
    public function add(int $id, string $name, int $weightInGrams);
    public function remove(int $id);
    public function list(array $filters): array;
}