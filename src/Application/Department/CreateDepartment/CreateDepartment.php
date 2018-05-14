<?php

namespace Inventory\Management\Application\Department\CreateDepartment;

use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Department\FoundNameDepartmentException;
use Inventory\Management\Domain\Service\Department\CheckNotExistNameDepartment;

class CreateDepartment
{
    private $departmentRepository;
    private $checkNotExistNameDepartment;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        CheckNotExistNameDepartment $checkNotExistNameDepartment
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->checkNotExistNameDepartment = $checkNotExistNameDepartment;
    }

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
