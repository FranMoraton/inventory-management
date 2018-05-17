<?php

namespace Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\FoundTelephoneEmployeeException;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\CheckNotExistTelephoneEmployee;
use Inventory\Management\Domain\Service\Util\EncryptPassword;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\Util\Observer\ListExceptions;

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
        ListExceptions::instance()->restartExceptions();
        ListExceptions::instance()->attach($searchEmployeeByNif);
        ListExceptions::instance()->attach($checkNotExistTelephoneEmployee);
    }

    public function handle(UpdateBasicFieldsEmployeeCommand $updateBasicFieldsEmployeeCommand): array
    {
        $this->checkNotExistTelephoneEmployee->execute(
            $updateBasicFieldsEmployeeCommand->telephone(),
            $updateBasicFieldsEmployeeCommand->nif()
        );
        $employee = $this->searchEmployeeByNif->execute(
            $updateBasicFieldsEmployeeCommand->nif()
        );
        if (ListExceptions::instance()->checkForExceptions()) {
            return ListExceptions::instance()->firstException();
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

        return [
            'data' => 'Se ha actualizado el trabajador con éxito',
            'code' => 200
        ];
    }
}
