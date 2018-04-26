<?php

namespace Inventory\Management\Application\Employee\CreateEmployee;

class CreateEmployeeTransform implements CreateEmployeeTransformInterface
{
    public function transform(): array
    {
        return ['ok' => 200];
    }
}
