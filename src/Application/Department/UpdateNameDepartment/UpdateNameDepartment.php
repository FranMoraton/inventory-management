<?php

namespace Inventory\Management\Application\Department\UpdateNameDepartment;

use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;

class UpdateNameDepartment
{
    private $departmentRepository;
    private $searchDepartmentById;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        SearchDepartmentById $searchDepartmentById
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->searchDepartmentById = $searchDepartmentById;
    }

    public function handle(UpdateNameDepartmentCommand $updateNameDepartmentCommand): array
    {
        try {
            $department = $this->searchDepartmentById->execute(
                $updateNameDepartmentCommand->department()
            );
        } catch (NotFoundDepartmentsException $notFoundDepartmentsException) {
            return ['ko' => $notFoundDepartmentsException->getMessage()];
        }
        $this->departmentRepository->updateNameDepartment(
            $department,
            $updateNameDepartmentCommand->name()
        );

        return ['ok' => 200];
    }
}
