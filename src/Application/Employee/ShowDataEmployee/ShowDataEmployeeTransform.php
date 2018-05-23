<?php

namespace Inventory\Management\Application\Employee\ShowDataEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;

class ShowDataEmployeeTransform implements ShowDataEmployeeTransformInterface
{
    public function transform(Employee $employee)
    {
        $listEmployee = [
            'name' => $employee->getName(),
            'inSsNumber' => $employee->getInSsNumber(),
            'telephone' => $employee->getTelephone()
        ];

        return $listEmployee;
    }
}
