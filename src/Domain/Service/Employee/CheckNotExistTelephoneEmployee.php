<?php

namespace Inventory\Management\Domain\Service\Employee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\FoundTelephoneEmployeeException;

class CheckNotExistTelephoneEmployee
{
    private $employeeRepository;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository
    ) {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param string $telephone
     * @throws FoundTelephoneEmployeeException
     */
    public function execute(string $telephone): void
    {
        $telephoneEmployee = $this->employeeRepository->checkNotExistsTelephoneEmployee($telephone);
        if (null !== $telephoneEmployee) {
            throw new FoundTelephoneEmployeeException();
        }
    }
}
