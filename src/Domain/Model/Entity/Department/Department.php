<?php

namespace Inventory\Management\Domain\Model\Entity\Department;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository")
 * @ORM\Table(name="department")
 */
class Department
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Inventory\Management\Domain\Model\Entity\Department\SubDepartment", mappedBy="department")
     */
    private $subDepartments;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection|SubDepartment[]
     */
    public function getSubDepartments(): Collection
    {
        return $this->subDepartments;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
