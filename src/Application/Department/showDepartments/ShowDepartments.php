<?php

namespace Inventory\Management\Application\Department\showDepartments;

use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;

class ShowDepartments
{
    private $departmentRepository;
    private $showDepartmentsTransform;

    public function __construct(
        DepartmentRepository $departmentRepository,
        ShowDepartmentsTransformInterface $showDepartmentsTransform
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->showDepartmentsTransform = $showDepartmentsTransform;
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        $listDepartments = $this->departmentRepository->showAllDepartments();
        if (0 === count($listDepartments)) {
            return ['ko' => 'No se han encontrado departamentos'];
        }

        return $this->showDepartmentsTransform
            ->transform($listDepartments);
    }
}
