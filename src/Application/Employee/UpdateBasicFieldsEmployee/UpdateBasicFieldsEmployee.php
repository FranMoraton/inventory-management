<?php

namespace Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\FoundTelephoneEmployeeException;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\CheckNotExistTelephoneEmployee;
use Inventory\Management\Domain\Service\Employee\EncryptPassword;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;

class UpdateBasicFieldsEmployee
{
    private $employeeRepository;
    private $searchEmployeeByNif;
    private $checkNotExistTelephoneEmployee;
    private $encryptPassword;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        SearchEmployeeByNif $searchEmployeeByNif,
        CheckNotExistTelephoneEmployee $checkNotExistTelephoneEmployee,
        EncryptPassword $encryptPassword
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
        $this->checkNotExistTelephoneEmployee = $checkNotExistTelephoneEmployee;
        $this->encryptPassword = $encryptPassword;
    }

    public function handle(UpdateBasicFieldsEmployeeCommand $updateBasicFieldsEmployeeCommand): array
    {
        try {
            $this->checkNotExistTelephoneEmployee->execute(
                $updateBasicFieldsEmployeeCommand->telephone()
            );
        } catch (FoundTelephoneEmployeeException $foundTelephoneEmployeeException) {
            return ['ko' => $foundTelephoneEmployeeException->getMessage()];
        }
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
            $updateBasicFieldsEmployeeCommand->name(),
            $updateBasicFieldsEmployeeCommand->telephone()
        );

        return ['ok' => 200];
    }
}
