<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(
 *      repositoryClass="App\Repository\UnitRepository",
 *     )
 * @ORM\Table(name="unit"
 *     )
 */
class Unit
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     *
     * @var string
     */
    private $id;
    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $name;
    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float
     */
    private $quantity;
    /**
    /**
     * @ORM\ManyToOne(targetEntity="Unit")
     * @0RM\JoinColumn(name="reference_unit_id", referencedColumnName="id")
     *
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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float|null
     */
    public function getQuantity(): ? float
    {
        return $this->quantity;
    }

    /**
     * @return Unit
     */
    public function getReferenceUnit(): ? Unit
    {
        return $this->referenceUnit;
    }
}
