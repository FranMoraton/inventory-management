<?php

namespace Inventory\Management\Application\Employee\CheckDataEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundPasswordEmployeeException;
use Inventory\Management\Domain\Service\Employee\CheckDecryptPassword;
use Inventory\Management\Domain\Service\Employee\SearchByNifEmployee;

class CheckDataEmployee
{
    private $searchByNifEmployee;
    private $checkDecryptPassword;

    public function __construct(SearchByNifEmployee $searchByNifEmployee, CheckDecryptPassword $checkDecryptPassword)
    {
        $this->searchByNifEmployee = $searchByNifEmployee;
        $this->checkDecryptPassword = $checkDecryptPassword;
    }

    /**
     * @param CheckDataEmployeeCommand $checkDataEmployeeCommand
     * @throws NotFoundEmployeesException
     * @throws NotFoundPasswordEmployeeException
     */
    public function handle(CheckDataEmployeeCommand $checkDataEmployeeCommand): void
    {
        $resultEmployee = $this->searchByNifEmployee->execute(
            $checkDataEmployeeCommand->nif()
        );
        $this->checkDecryptPassword->execute(
            $checkDataEmployeeCommand->password(),
            $resultEmployee->getPassword()
        );
    }
}
