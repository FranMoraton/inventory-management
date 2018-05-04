<?php

namespace Inventory\Management\Application\Department\UpdateNameDepartment;

use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;

class UpdateNameDepartment
{
    private $departmentRepository;
    private $searchDepartmentById;

    public function __construct(
        DepartmentRepository $departmentRepository,
        SearchDepartmentById $searchDepartmentById
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->searchDepartmentById = $searchDepartmentById;
    }

    /**
     * @param UpdateNameDepartmentCommand $updateNameDepartmentCommand
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
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
