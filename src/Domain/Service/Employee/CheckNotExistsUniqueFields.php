<?php

namespace Inventory\Management\Domain\Service\Employee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepository;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatusRepository;
use Inventory\Management\Domain\Model\Entity\Employee\FoundCodeEmployeeStatusException;
use Inventory\Management\Domain\Model\Entity\Employee\FoundInSsNumberEmployeeException;
use Inventory\Management\Domain\Model\Entity\Employee\FoundNifEmployeeException;
use Inventory\Management\Domain\Model\Entity\Employee\FoundTelephoneEmployeeException;
use Inventory\Management\Domain\Model\Entity\Employee\CheckNotExistsUniqueFields as CheckNotExistsUniqueFieldsI;

class CheckNotExistsUniqueFields implements CheckNotExistsUniqueFieldsI
{
    private $employeeRepository;
    private $employeeStatusRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,
        EmployeeStatusRepository $employeeStatusRepository
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->employeeStatusRepository = $employeeStatusRepository;
    }

    /**
     * @param string $nif
     * @param string $inSsNumber
     * @param string $telephone
     * @param string $codeEmployee
     * @throws FoundCodeEmployeeStatusException
     * @throws FoundInSsNumberEmployeeException
     * @throws FoundNifEmployeeException
     * @throws FoundTelephoneEmployeeException
     */
    public function execute(
        string $nif,
        string $inSsNumber,
        string $telephone,
        string $codeEmployee
    ): void {
        $nifEmployee = $this->employeeRepository->findEmployeeByNif($nif);
        if (null !== $nifEmployee) {
            throw new FoundNifEmployeeException();
        }
        $inSsNumberEmployee = $this->employeeRepository->checkNotExistsInSsNumberEmployee($inSsNumber);
        if (null !== $inSsNumberEmployee) {
            throw new FoundInSsNumberEmployeeException();
        }
        $telephoneEmployee = $this->employeeRepository->checkNotExistsTelephoneEmployee($telephone, $nif);
        if (null !== $telephoneEmployee) {
            throw new FoundTelephoneEmployeeException();
        }
        $codeEmployeeStatus = $this->employeeStatusRepository->checkNotExistsCodeEmployeeStatus($codeEmployee);
        if (null !== $codeEmployeeStatus) {
            throw new FoundCodeEmployeeStatusException();
        }
    }
}
