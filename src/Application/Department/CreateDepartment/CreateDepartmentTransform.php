<?php

namespace Inventory\Management\Application\Department\CreateDepartment;

class CreateDepartmentTransform implements CreateDepartmentTransformInterface
{
    public function transform()
    {
        return ['ok' => 200];
    }
}
