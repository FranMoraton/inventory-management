<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeByNif;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;

interface ShowEmployeeByNifTransformInterface
{
    public function transform(Employee $employee);
}
