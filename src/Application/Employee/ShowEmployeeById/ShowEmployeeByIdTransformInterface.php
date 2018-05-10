<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeById;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;

interface ShowEmployeeByIdTransformInterface
{
    public function transform(Employee $employee);
}
