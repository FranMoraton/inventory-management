<?php

namespace Inventory\Management\Application\Department\CreateSubDepartment;

use Inventory\Management\Domain\Model\Entity\Department\FoundNameSubDepartmentException;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartmentRepositoryInterface;
use Inventory\Management\Domain\Service\Department\CheckNotExistNameSubDepartment;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;

class CreateSubDepartment
{
    private $subDepartmentRepository;
    private $searchDepartmentById;
    private $checkNotExistNameSubDepartment;

    public function __construct(
        SubDepartmentRepositoryInterface $subDepartmentRepository,
        SearchDepartmentById $searchDepartmentById,
        CheckNotExistNameSubDepartment $checkNotExistNameSubDepartment
    ) {
        $this->subDepartmentRepository = $subDepartmentRepository;
        $this->searchDepartmentById = $searchDepartmentById;
        $this->checkNotExistNameSubDepartment = $checkNotExistNameSubDepartment;
    }

    public function handle(CreateSubDepartmentCommand $createSubDepartmentCommand): array
    {
        try {
            $this->checkNotExistNameSubDepartment->execute(
                $createSubDepartmentCommand->name()
            );
        } catch (FoundNameSubDepartmentException $foundNameSubDepartmentException) {
            return ['ko' => $foundNameSubDepartmentException->getMessage()];
        }
        try {
            $department = $this->searchDepartmentById->execute(
                $createSubDepartmentCommand->department()
            );
        } catch (NotFoundDepartmentsException $notFoundDepartmentsException) {
            return ['ko' => $notFoundDepartmentsException->getMessage()];
        }
        $subDepartment = new SubDepartment(
            $department,
            $createSubDepartmentCommand->name()
        );
        $this->subDepartmentRepository->createSubDepartment($subDepartment);

        return ['ok' => 200];
    }
}
