<?php

namespace Inventory\Management\Application\Department\showDepartments;

use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;

class ShowDepartments
{
    private $departmentRepository;
    private $showDepartmentsTransform;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        ShowDepartmentsTransformInterface $showDepartmentsTransform
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->showDepartmentsTransform = $showDepartmentsTransform;
    }

    public function handle(): array
    {
        $listDepartments = $this->departmentRepository->showAllDepartments();

        return [
            'data' => $this->showDepartmentsTransform->transform($listDepartments),
            'code' => 200
        ];
    }
}
