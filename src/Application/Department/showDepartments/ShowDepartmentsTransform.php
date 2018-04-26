<?php

namespace Inventory\Management\Application\Department\showDepartments;

use Inventory\Management\Domain\Model\Entity\Department\Department;

class ShowDepartmentsTransform implements ShowDepartmentsTransformInterface
{
    /**
     * @param array|Department[] $departments
     * @return array
     */
    public function transform(array $departments): array
    {
        $listDepartments = [];
        foreach ($departments as $department) {
            $listSubDepartments = [];
            $subDepartments = $department->getSubDepartments();
            foreach ($subDepartments as $subDepartment) {
                $listSubDepartments[] = [
                    'id' => $subDepartment->getId(),
                    'name' => $subDepartment->getName()
                ];
            }
            $listDepartments[] = [
                'id' => $department->getId(),
                'name' => $department->getName(),
                'subDepartments' => $listSubDepartments
            ];
        }

        return $listDepartments;
    }
}
