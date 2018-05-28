<?php

namespace Inventory\Management\Application\Department\CreateDepartment;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Department\CheckNotExistNameDepartment;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class CreateDepartment extends RoleAdmin
{
    private $departmentRepository;
    private $checkNotExistNameDepartment;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        CheckNotExistNameDepartment $checkNotExistNameDepartment,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->departmentRepository = $departmentRepository;
        $this->checkNotExistNameDepartment = $checkNotExistNameDepartment;
    }

    /**
     * @param CreateDepartmentCommand $createDepartmentCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Department\FoundNameDepartmentException
     */
    public function handle(CreateDepartmentCommand $createDepartmentCommand): array
    {
        $this->checkNotExistNameDepartment->execute(
            $createDepartmentCommand->name()
        );
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
