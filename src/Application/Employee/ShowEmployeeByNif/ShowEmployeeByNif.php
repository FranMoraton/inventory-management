<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeByNif;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\Util\Observer\ListExceptions;

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
        ListExceptions::instance()->restartExceptions();
        ListExceptions::instance()->attach($this->searchEmployeeByNif);
    }

    public function handle(ShowEmployeeByNifCommand $showEmployeeByNifCommand)
    {
        $employee = $this->searchEmployeeByNif->execute(
            $showEmployeeByNifCommand->nif()
        );
        if (0 !== count(ListExceptions::instance()->showExceptions())) {
            return ListExceptions::instance()->showExceptions()[0];
        }

        return [
            'data' => $this->showEmployeeByNifTransform->transform($employee),
            'code' => 200
        ];
    }
}
