<?php

namespace Inventory\Management\Application\Department\CreateDepartment;

use Doctrine\ORM\ORMException;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\FoundNameDepartmentException;
use Inventory\Management\Domain\Service\Department\CheckNotExistNameDepartment;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;

class CreateDepartment
{
    private $departmentRepository;
    private $checkNotExistNameDepartment;

    public function __construct(
        DepartmentRepository $departmentRepository,
        CheckNotExistNameDepartment $checkNotExistNameDepartment
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->checkNotExistNameDepartment = $checkNotExistNameDepartment;
    }

    /**
     * @param CreateDepartmentCommand $createDepartmentCommand
     * @return array
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(CreateDepartmentCommand $createDepartmentCommand): array
    {
        try {
            $this->checkNotExistNameDepartment->execute(
                $createDepartmentCommand->name()
            );
        } catch (FoundNameDepartmentException $foundNameDepartmentException) {
            return ['ko' => $foundNameDepartmentException->getMessage()];
        }
        $department = new Department(
            $createDepartmentCommand->name()
        );
        $this->departmentRepository->createDepartment($department);

        return ['ok' => 200];
    }
}
