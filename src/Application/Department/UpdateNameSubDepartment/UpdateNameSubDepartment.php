<?php

namespace Inventory\Management\Application\Department\UpdateNameSubDepartment;

use Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;

class UpdateNameSubDepartment
{
    private $subDepartmentRepository;
    private $searchSubDepartmentById;

    public function __construct(
        SubDepartmentRepository $subDepartmentRepository,
        SearchSubDepartmentById $searchSubDepartmentById
    ) {
        $this->subDepartmentRepository = $subDepartmentRepository;
        $this->searchSubDepartmentById = $searchSubDepartmentById;
    }

    /**
     * @param UpdateNameSubDepartmentCommand $updateNameSubDepartmentCommand
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
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
