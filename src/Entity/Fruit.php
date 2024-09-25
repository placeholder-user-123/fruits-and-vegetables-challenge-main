<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\FruitRepository')]
#[ORM\Table(name: 'fruit')]
class Fruit
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $weightInGrams;

    public function __construct(int $id, string $name, int $weightInGrams)
    {
        $this->id = $id;
        $this->name = $name;
        $this->weightInGrams = $weightInGrams;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'weightInGrams' => $this->weightInGrams,
        ];
    }
}