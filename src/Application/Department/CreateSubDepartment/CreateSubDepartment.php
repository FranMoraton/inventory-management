<?php

namespace Inventory\Management\Application\Department\CreateSubDepartment;

use Doctrine\ORM\ORMException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;

class CreateSubDepartment
{
    private $departmentRepository;
    private $subDepartmentRepository;

    public function __construct(
        DepartmentRepository $departmentRepository,
        SubDepartmentRepository $subDepartmentRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->subDepartmentRepository = $subDepartmentRepository;
    }

    /**
     * @param CreateSubDepartmentCommand $createSubDepartmentCommand
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(CreateSubDepartmentCommand $createSubDepartmentCommand)
    {
        $idDepartment = $createSubDepartmentCommand->department();
        $nameSubDepartment = $createSubDepartmentCommand->name();
        $searchedDepartment = $this->departmentRepository->searchByIdDepartment($idDepartment);
        $subDepartment = new SubDepartment(
            $searchedDepartment,
            $nameSubDepartment
        );
        $this->subDepartmentRepository->createSubDepartment($subDepartment);
    }
}
