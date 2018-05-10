<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeById;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;

class ShowEmployeeById
{
    private $employeeRepository;
    private $showEmployeeByIdTransform;
    private $searchEmployeeByNif;

    public function __construct(
        EmployeeRepository $employeeRepository,
        ShowEmployeeByIdTransformInterface $showEmployeeByIdTransform,
        SearchEmployeeByNif $searchEmployeeByNif
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->showEmployeeByIdTransform = $showEmployeeByIdTransform;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
    }

    public function handle(ShowEmployeeByIdCommand $showEmployeeByIdCommand)
    {
        try {
            $employee = $this->searchEmployeeByNif->execute(
                $showEmployeeByIdCommand->nif()
            );
        } catch (NotFoundEmployeesException $notFoundEmployeesException) {
            return ['ko' => $notFoundEmployeesException->getMessage()];
        }

        return $this->showEmployeeByIdTransform
            ->transform($employee);
    }
}
