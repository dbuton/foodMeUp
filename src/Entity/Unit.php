<?php

namespace App\Entity;

class Unit
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var float
     */
    private $quantity;
    /**
     * @var Unit
     */
    private $referenceUnit;

    /**
     * Unit constructor.
     *
     * @param string $name
     * @param float  $quantity
     * @param Unit   $referenceUnit
     */
    public function __construct($name, $quantity, Unit $referenceUnit)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->referenceUnit = $referenceUnit;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return Unit
     */
    public function getReferenceUnit()
    {
        return $this->referenceUnit;
    }
}
