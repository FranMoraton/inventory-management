<?php

namespace Inventory\Management\Application\Department\UpdateNameSubDepartment;

use Inventory\Management\Domain\Model\Entity\Department\SubDepartmentRepositoryInterface;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\Util\Observer\ListExceptions;

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
        ListExceptions::instance()->restartExceptions();
        ListExceptions::instance()->attach($searchSubDepartmentById);
    }

    public function handle(UpdateNameSubDepartmentCommand $updateNameSubDepartmentCommand)
    {
        $subDepartment = $this->searchSubDepartmentById->execute(
            $updateNameSubDepartmentCommand->subDepartment()
        );
        if (ListExceptions::instance()->checkForExceptions()) {
            return ListExceptions::instance()->firstException();
        }
        $this->subDepartmentRepository->updateNameSubDepartment(
            $subDepartment,
            $updateNameSubDepartmentCommand->name()
        );

        return [
            'data' => 'Se ha actualizado el nombre del subdepartamento con éxito',
            'code' => 200
        ];
    }
}
