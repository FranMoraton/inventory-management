<?php

namespace Inventory\Management\Application\Employee\ShowByFirstResultEmployees;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class ShowByFirstResultEmployees extends RoleAdmin
{
    private $employeeRepository;
    private $showEmployeesTransform;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        ShowByFirstResultEmployeesTransformInterface $showEmployeesTransform,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->employeeRepository = $employeeRepository;
        $this->showEmployeesTransform = $showEmployeesTransform;
    }

    /**
     * @param ShowByFirstResultEmployeesCommand $showEmployeesCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidRoleTokenException
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidTokenException
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidUserTokenException
     */
    public function handle(ShowByFirstResultEmployeesCommand $showEmployeesCommand): array
    {
        $this->checkToken();
        $listEmployees = $this->employeeRepository->showByFirstResultEmployees(
            $showEmployeesCommand->firstResultPosition()
        );

        return [
            'data' => $this->showEmployeesTransform->transform($listEmployees),
            'code' => HttpResponses::OK
        ];
    }
}
