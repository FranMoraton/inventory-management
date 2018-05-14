<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeByNif;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;

class ShowEmployeeByNif
{
    private $showEmployeeByNifTransform;
    private $searchEmployeeByNif;

    public function __construct(
        ShowEmployeeByNifTransformInterface $showEmployeeByNifTransform,
        SearchEmployeeByNif $searchEmployeeByNif
    ) {
        $this->showEmployeeByNifTransform = $showEmployeeByNifTransform;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
    }

    public function handle(ShowEmployeeByNifCommand $showEmployeeByNifCommand)
    {
        try {
            $employee = $this->searchEmployeeByNif->execute(
                $showEmployeeByNifCommand->nif()
            );
        } catch (NotFoundEmployeesException $notFoundEmployeesException) {
            return ['ko' => $notFoundEmployeesException->getMessage()];
        }

        return $this->showEmployeeByNifTransform
            ->transform($employee);
    }
}
