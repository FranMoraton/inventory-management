<?php

namespace Inventory\Management\Application\Department\UpdateNameSubDepartment;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class UpdateNameSubDepartment extends RoleAdmin
{
    private $subDepartmentRepository;
    private $searchSubDepartmentById;

    public function __construct(
        SubDepartmentRepositoryInterface $subDepartmentRepository,
        SearchSubDepartmentById $searchSubDepartmentById,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->subDepartmentRepository = $subDepartmentRepository;
        $this->searchSubDepartmentById = $searchSubDepartmentById;
    }

    /**
     * @param UpdateNameSubDepartmentCommand $updateNameSubDepartmentCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException
     */
    public function handle(UpdateNameSubDepartmentCommand $updateNameSubDepartmentCommand)
    {
        $subDepartment = $this->searchSubDepartmentById->execute(
            $updateNameSubDepartmentCommand->subDepartment()
        );
        $this->subDepartmentRepository->updateNameSubDepartment(
            $subDepartment,
            $updateNameSubDepartmentCommand->name()
        );

        return [
            'data' => 'Se ha actualizado el nombre del subdepartamento con éxito',
            'code' => HttpResponses::OK
        ];
    }
}
