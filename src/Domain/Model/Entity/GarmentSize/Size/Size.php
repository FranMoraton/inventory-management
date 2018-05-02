<?php

namespace Inventory\Management\Domain\Model\Entity\GarmentSize\Size;

use Doctrine\ORM\Mapping as ORM;
use Inventory\Management\Domain\Model\Entity\GarmentSize\Garment\GarmentType;

/**
 * @ORM\Entity(repositoryClass="Inventory\Management\Infrastructure\Repository\GarmentSize\Size\SizeRepository")
 * @ORM\Table(name="size")
 */
class Size
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Inventory\Management\Domain\Model\Entity\GarmentSize\Garment\GarmentType", inversedBy="sizes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $garmentType;

    /**
     * @ORM\Column(type="string", length=3, nullable=false)
     */
    private $sizeValue;

    public function getId(): int
    {
        return $this->id;
    }

    public function getGarmentType(): GarmentType
    {
        return $this->garmentType;
    }

    public function getSizeValue(): string
    {
        return $this->sizeValue;
    }

    public function setSizeValue(string $sizeValue): void
    {
        $this->sizeValue = $sizeValue;
    }
}
