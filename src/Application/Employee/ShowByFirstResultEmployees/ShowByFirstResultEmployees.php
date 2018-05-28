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

    public function handle(ShowByFirstResultEmployeesCommand $showEmployeesCommand): array
    {
        $listEmployees = $this->employeeRepository->showByFirstResultFilterEmployees(
            $showEmployeesCommand->firstResultPosition(),
            $showEmployeesCommand->name(),
            $showEmployeesCommand->code(),
            $showEmployeesCommand->department(),
            $showEmployeesCommand->subDepartment()
        );

        return [
            'data' => $this->showEmployeesTransform->transform($listEmployees),
            'code' => HttpResponses::OK
        ];
    }
}
