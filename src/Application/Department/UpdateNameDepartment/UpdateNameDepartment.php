<?php

namespace Inventory\Management\Application\Department\UpdateNameDepartment;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class UpdateNameDepartment extends RoleAdmin
{
    private $departmentRepository;
    private $searchDepartmentById;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        SearchDepartmentById $searchDepartmentById,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->departmentRepository = $departmentRepository;
        $this->searchDepartmentById = $searchDepartmentById;
    }

    /**
     * @param UpdateNameDepartmentCommand $updateNameDepartmentCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException
     */
    public function handle(UpdateNameDepartmentCommand $updateNameDepartmentCommand): array
    {
        $department = $this->searchDepartmentById->execute(
            $updateNameDepartmentCommand->department()
        );
        $this->departmentRepository->updateNameDepartment(
            $department,
            $updateNameDepartmentCommand->name()
        );

        return [
            'data' => 'Se ha actualizado el nombre del departamento con éxito',
            'code' => HttpResponses::OK
        ];
    }
}
