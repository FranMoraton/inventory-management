<?php

namespace Inventory\Management\Application\Employee\CheckLoginEmployee;

use Inventory\Management\Application\Util\JwtToken\CreateToken;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Util\CheckDecryptPassword;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Util\Observer\ListExceptions;

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
        ListExceptions::instance()->restartExceptions();
        ListExceptions::instance()->attach($searchEmployeeByNif);
        ListExceptions::instance()->attach($checkDecryptPassword);
    }

    public function handle(CheckLoginEmployeeCommand $checkLoginEmployeeCommand): array
    {
        $employee = $this->searchEmployeeByNif->execute(
            $checkLoginEmployeeCommand->nif()
        );
        $this->checkDecryptPassword->execute(
            $checkLoginEmployeeCommand->password(),
            null !== $employee ? $employee->getPassword() : ''
        );
        if (ListExceptions::instance()->checkForExceptions()) {
            return ListExceptions::instance()->firstException();
        }
        $token = $this->createToken->handle([
            'id' => $employee->getId(),
            'nif' => $employee->getNif()
        ]);
        $this->employeeRepository->updateTokenEmployee($employee, $token);

        return [
            'data' => 'Los datos introducidos son correctos',
            'code' => HttpResponses::OK
        ];
    }
}
