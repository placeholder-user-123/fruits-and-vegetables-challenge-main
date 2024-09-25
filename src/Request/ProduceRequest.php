<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class ProduceRequest
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @Assert\GreaterThan(0)
     */
    public $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Name must be at least {{ limit }} characters long",
     *      maxMessage = "Name cannot be longer than {{ limit }} characters"
     * )
     */
    public $name;

    /**
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @Assert\GreaterThan(0)
     */
    public $quantity;

    /**
     * @Assert\NotBlank
     * @Assert\Choice(choices={"g", "kg"}, message="Unit must be either 'g' or 'kg'")
     */
    public $unit;

    /**
     * @Assert\NotBlank
     * @Assert\Choice(choices={"vegetable", "fruit"}, message="Type must be either 'vegetable' or 'fruit'")
     */
    public $type;

    public function __construct($data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->quantity = $data['quantity'] ?? null; // assuming "quantity" is weight in JSON
        $this->unit = $data['unit'] ?? null;
        $this->type = $data['type'] ?? null;
    }
}