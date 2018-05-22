<?php

namespace Inventory\Management\Application\Employee\ShowDataEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;

interface ShowDataEmployeeTransformInterface
{
    public function transform(Employee $employee);
}
