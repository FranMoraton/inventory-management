<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee;

class ChangeStatusToDisableEmployeeTransform implements ChangeStatusToDisableEmployeeTransformInterface
{
    public function transform()
    {
        return ['ok' => 200];
    }
}
