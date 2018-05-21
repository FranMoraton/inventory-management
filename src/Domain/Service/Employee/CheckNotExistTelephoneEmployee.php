<?php

namespace Inventory\Management\Domain\Service\Employee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\FoundTelephoneEmployeeException;
use Inventory\Management\Domain\Util\Observer\ListExceptions;
use Inventory\Management\Domain\Util\Observer\Observer;

class CheckNotExistTelephoneEmployee implements Observer
{
    private $stateException;
    private $employeeRepository;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository
    ) {
        $this->stateException = false;
        $this->employeeRepository = $employeeRepository;
    }

    public function execute(string $telephone, string $nif): void
    {
        $telephoneEmployee = $this->employeeRepository->checkNotExistsTelephoneEmployee($telephone, $nif);
        if (null !== $telephoneEmployee) {
            $this->stateException = true;
            ListExceptions::instance()->notify();
        }
    }

    /**
     * @throws FoundTelephoneEmployeeException
     */
    public function update()
    {
        if ($this->stateException) {
            throw new FoundTelephoneEmployeeException();
        }
    }
}
