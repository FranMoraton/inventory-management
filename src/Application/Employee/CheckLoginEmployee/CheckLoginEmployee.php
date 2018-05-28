<?php

namespace Inventory\Management\Application\Employee\CheckLoginEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Model\JwtToken\Roles;
use Inventory\Management\Domain\Service\PasswordHash\CheckDecryptPassword;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\JwtToken\CreateToken;

class CheckLoginEmployee
{
    private $employeeRepository;
    private $searchEmployeeByNif;
    private $checkDecryptPassword;
    private $createToken;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        SearchEmployeeByNif $searchEmployeeByNif,
        CheckDecryptPassword $checkDecryptPassword,
        CreateToken $createToken
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
        $this->checkDecryptPassword = $checkDecryptPassword;
        $this->createToken = $createToken;
    }

    /**
     * @param CheckLoginEmployeeCommand $checkLoginEmployeeCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException
     * @throws \Inventory\Management\Domain\Model\PasswordHash\IncorrectPasswordException
     */
    public function handle(CheckLoginEmployeeCommand $checkLoginEmployeeCommand): array
    {
        $employee = $this->searchEmployeeByNif->execute(
            $checkLoginEmployeeCommand->nif()
        );
        $this->checkDecryptPassword->execute(
            $checkLoginEmployeeCommand->password(),
            null !== $employee ? $employee->getPassword() : ''
        );
        $token = $this->createToken->execute(
            Roles::ROLE_EMPLOYEE,
            [
                'id' => $employee->getId(),
                'nif' => $employee->getNif()
            ]
        );

        return [
            'data' => $token,
            'code' => HttpResponses::OK
        ];
    }
}
