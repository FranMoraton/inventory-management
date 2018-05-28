<?php

namespace Inventory\Management\Application\Department\CreateSubDepartment;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Department\CheckNotExistNameSubDepartment;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class CreateSubDepartment extends RoleAdmin
{
    private $subDepartmentRepository;
    private $searchDepartmentById;
    private $checkNotExistNameSubDepartment;

    public function __construct(
        SubDepartmentRepositoryInterface $subDepartmentRepository,
        SearchDepartmentById $searchDepartmentById,
        CheckNotExistNameSubDepartment $checkNotExistNameSubDepartment,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->subDepartmentRepository = $subDepartmentRepository;
        $this->searchDepartmentById = $searchDepartmentById;
        $this->checkNotExistNameSubDepartment = $checkNotExistNameSubDepartment;
    }

    /**
     * @param CreateSubDepartmentCommand $createSubDepartmentCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Department\FoundNameSubDepartmentException
     * @throws \Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException
     */
    public function handle(CreateSubDepartmentCommand $createSubDepartmentCommand): array
    {
        $this->checkNotExistNameSubDepartment->execute(
            $createSubDepartmentCommand->name()
        );
        $department = $this->searchDepartmentById->execute(
            $createSubDepartmentCommand->department()
        );
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
