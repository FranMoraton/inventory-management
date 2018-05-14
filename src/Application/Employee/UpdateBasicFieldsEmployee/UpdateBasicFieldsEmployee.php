<?php

namespace Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\EncryptPassword;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;

class UpdateBasicFieldsEmployee
{
    private $employeeRepository;
    private $searchEmployeeByNif;
    private $encryptPassword;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        SearchEmployeeByNif $searchEmployeeByNif,
        EncryptPassword $encryptPassword
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
        $this->encryptPassword = $encryptPassword;
    }

    public function handle(UpdateBasicFieldsEmployeeCommand $updateBasicFieldsEmployeeCommand): array
    {
        try {
            $employee = $this->searchEmployeeByNif->execute(
                $updateBasicFieldsEmployeeCommand->nif()
            );
        } catch (NotFoundEmployeesException $notFoundEmployeesException) {
            return ['ko' => $notFoundEmployeesException->getMessage()];
        }
        $passwordHash = $this->encryptPassword->execute(
            $updateBasicFieldsEmployeeCommand->password()
        );
        $this->employeeRepository->updateBasicFieldsEmployee(
            $employee,
            $passwordHash,
            $updateBasicFieldsEmployeeCommand
        );

        return ['ok' => 200];
    }
}
