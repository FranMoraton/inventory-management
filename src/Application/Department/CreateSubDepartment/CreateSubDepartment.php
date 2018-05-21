<?php

namespace Inventory\Management\Application\Department\CreateSubDepartment;

use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Department\CheckNotExistNameSubDepartment;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Domain\Util\Observer\ListExceptions;

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
        ListExceptions::instance()->restartExceptions();
        ListExceptions::instance()->attach($checkNotExistNameSubDepartment);
        ListExceptions::instance()->attach($searchDepartmentById);
    }

    public function handle(CreateSubDepartmentCommand $createSubDepartmentCommand): array
    {
        $this->checkNotExistNameSubDepartment->execute(
            $createSubDepartmentCommand->name()
        );
        $department = $this->searchDepartmentById->execute(
            $createSubDepartmentCommand->department()
        );
        if (ListExceptions::instance()->checkForExceptions()) {
            return ListExceptions::instance()->firstException();
        }
        $subDepartment = new SubDepartment(
            $department,
            $createSubDepartmentCommand->name()
        );
        $this->subDepartmentRepository->createSubDepartment($subDepartment);

        return [
            'data' => 'Se ha creado el subdepartamento con éxito',
            'code' => HttpResponses::OK_CREATED
        ];
    }
}
