<?php

namespace App\Service;

use App\Repository\ProductRepositoryInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

class ProduceServiceFactory
{
    public function __construct(private ServiceLocator $serviceLocator)
    {
    }

    public function getRepository(string $type): ProductRepositoryInterface
    {
        if (!$this->serviceLocator->has($type)) {
            throw new \InvalidArgumentException(sprintf('Invalid produce type "%s"', $type));
        }

        return $this->serviceLocator->get($type);
    }
}