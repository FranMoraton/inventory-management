<?php

namespace Inventory\Management\Application\Department\showDepartments;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class ShowDepartments extends RoleAdmin
{
    private $departmentRepository;
    private $showDepartmentsTransform;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        ShowDepartmentsTransformInterface $showDepartmentsTransform,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->departmentRepository = $departmentRepository;
        $this->showDepartmentsTransform = $showDepartmentsTransform;
    }

    /**
     * @return array
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidRoleTokenException
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidTokenException
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidUserTokenException
     */
    public function handle(): array
    {
        $this->checkToken();
        $listDepartments = $this->departmentRepository->showAllDepartments();

        return [
            'data' => $this->showDepartmentsTransform->transform($listDepartments),
            'code' => HttpResponses::OK
        ];
    }
}
