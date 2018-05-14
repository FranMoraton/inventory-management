<?php

namespace Inventory\Management\Application\Employee\CheckLoginEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundPasswordEmployeeException;
use Inventory\Management\Domain\Service\Employee\CheckDecryptPassword;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;

class CheckLoginEmployee
{
    private $searchEmployeeByNif;
    private $checkDecryptPassword;

    public function __construct(SearchEmployeeByNif $searchEmployeeByNif, CheckDecryptPassword $checkDecryptPassword)
    {
        $this->searchEmployeeByNif = $searchEmployeeByNif;
        $this->checkDecryptPassword = $checkDecryptPassword;
    }

    public function handle(CheckLoginEmployeeCommand $checkLoginEmployeeCommand): array
    {
        try {
            $resultEmployee = $this->searchEmployeeByNif->execute(
                $checkLoginEmployeeCommand->nif()
            );
        } catch (NotFoundEmployeesException $notFoundEmployeesException) {
            return ['ko' => $notFoundEmployeesException->getMessage()];
        }
        try {
            $this->checkDecryptPassword->execute(
                $checkLoginEmployeeCommand->password(),
                $resultEmployee->getPassword()
            );
        } catch (NotFoundPasswordEmployeeException $notFoundPasswordEmployeeException) {
            return ['ko' => $notFoundPasswordEmployeeException->getMessage()];
        }

        return ['ok' => 200];
    }
}
