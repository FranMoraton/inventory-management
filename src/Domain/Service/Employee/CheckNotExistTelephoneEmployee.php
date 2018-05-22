<?php

namespace Inventory\Management\Domain\Service\Employee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\FoundTelephoneEmployeeException;

class CheckNotExistTelephoneEmployee
{
    private $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param string $telephone
     * @param string $nif
     * @throws FoundTelephoneEmployeeException
     */
    public function execute(string $telephone, string $nif): void
    {
        $telephoneEmployee = $this->employeeRepository->checkNotExistsTelephoneEmployee($telephone, $nif);
        if (null !== $telephoneEmployee) {
            throw new FoundTelephoneEmployeeException();
        }
    }
}
