<?php

namespace Inventory\Management\Domain\Service\Employee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatusRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\FoundCodeEmployeeStatusException;
use Inventory\Management\Domain\Model\Entity\Employee\FoundInSsNumberEmployeeException;
use Inventory\Management\Domain\Model\Entity\Employee\FoundNifEmployeeException;
use Inventory\Management\Domain\Model\Entity\Employee\FoundTelephoneEmployeeException;
use Inventory\Management\Domain\Service\Util\Observer\ListExceptions;
use Inventory\Management\Domain\Service\Util\Observer\Observer;

class CheckNotExistsUniqueFields implements Observer
{
    private $stateExceptionNif;
    private $stateExceptionInSsNumber;
    private $stateExceptionTelephone;
    private $stateExceptionCode;
    private $employeeRepository;
    private $employeeStatusRepository;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        EmployeeStatusRepositoryInterface $employeeStatusRepository
    ) {
        $this->stateExceptionNif = false;
        $this->stateExceptionInSsNumber = false;
        $this->stateExceptionTelephone = false;
        $this->stateExceptionCode = false;
        $this->employeeRepository = $employeeRepository;
        $this->employeeStatusRepository = $employeeStatusRepository;
    }

    public function execute(
        string $nif,
        string $inSsNumber,
        string $telephone,
        string $codeEmployee
    ): void {
        $nifEmployee = $this->employeeRepository->findEmployeeByNif($nif);
        if (null !== $nifEmployee) {
            $this->stateExceptionNif = true;
        }
        $inSsNumberEmployee = $this->employeeRepository->checkNotExistsInSsNumberEmployee($inSsNumber);
        if (null !== $inSsNumberEmployee) {
            $this->stateExceptionInSsNumber = true;
        }
        $telephoneEmployee = $this->employeeRepository->checkNotExistsTelephoneEmployee($telephone, $nif);
        if (null !== $telephoneEmployee) {
            $this->stateExceptionTelephone = true;
        }
        $codeEmployeeStatus = $this->employeeStatusRepository->checkNotExistsCodeEmployeeStatus($codeEmployee);
        if (null !== $codeEmployeeStatus) {
            $this->stateExceptionCode = true;
        }
        ListExceptions::instance()->notify();
    }

    /**
     * @throws FoundCodeEmployeeStatusException
     * @throws FoundInSsNumberEmployeeException
     * @throws FoundNifEmployeeException
     * @throws FoundTelephoneEmployeeException
     */
    public function update()
    {
        switch (true) {
            case $this->stateExceptionNif:
                throw new FoundNifEmployeeException();
            case $this->stateExceptionInSsNumber:
                throw new FoundInSsNumberEmployeeException();
            case $this->stateExceptionTelephone:
                throw new FoundTelephoneEmployeeException();
            case $this->stateExceptionCode:
                throw new FoundCodeEmployeeStatusException();
        }
    }
}
