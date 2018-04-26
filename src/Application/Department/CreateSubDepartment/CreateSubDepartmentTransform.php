<?php

namespace Inventory\Management\Application\Department\CreateSubDepartment;

class CreateSubDepartmentTransform implements CreateSubDepartmentTransformInterface
{
    public function transform()
    {
        return ['ok' => 200];
    }
}
