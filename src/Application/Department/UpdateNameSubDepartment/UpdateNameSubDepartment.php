<?php

namespace Inventory\Management\Application\Department\UpdateNameSubDepartment;

use Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartmentRepositoryInterface;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;

class UpdateNameSubDepartment
{
    private $subDepartmentRepository;
    private $searchSubDepartmentById;

    public function __construct(
        SubDepartmentRepositoryInterface $subDepartmentRepository,
        SearchSubDepartmentById $searchSubDepartmentById
    ) {
        $this->subDepartmentRepository = $subDepartmentRepository;
        $this->searchSubDepartmentById = $searchSubDepartmentById;
    }

    public function handle(UpdateNameSubDepartmentCommand $updateNameSubDepartmentCommand)
    {
        try {
            $subDepartment = $this->searchSubDepartmentById->execute(
                $updateNameSubDepartmentCommand->subDepartment()
            );
        } catch (NotFoundSubDepartmentsException $notFoundDepartmentsException) {
            return ['ko' => $notFoundDepartmentsException->getMessage()];
        }
        $this->subDepartmentRepository->updateNameSubDepartment(
            $subDepartment,
            $updateNameSubDepartmentCommand->name()
        );

        return ['ok' => 200];
    }
}
