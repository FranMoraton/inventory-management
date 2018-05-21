<?php

namespace Inventory\Management\Application\Department\CreateDepartment;

use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Department\CheckNotExistNameDepartment;
use Inventory\Management\Domain\Util\Observer\ListExceptions;

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
        ListExceptions::instance()->restartExceptions();
        ListExceptions::instance()->attach($checkNotExistNameDepartment);
    }

    public function handle(CreateDepartmentCommand $createDepartmentCommand): array
    {
        $this->checkNotExistNameDepartment->execute(
            $createDepartmentCommand->name()
        );
        if (ListExceptions::instance()->checkForExceptions()) {
            return ListExceptions::instance()->firstException();
        }
        $department = new Department(
            $createDepartmentCommand->name()
        );
        $this->departmentRepository->createDepartment($department);

        return [
            'data' => 'Se ha creado el departamento con éxito',
            'code' => HttpResponses::OK_CREATED
        ];
    }
}
