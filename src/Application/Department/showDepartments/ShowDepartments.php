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
        if (0 === count($listDepartments)) {
            return ['ko' => 'No se han encontrado departamentos'];
        }

        return $this->showDepartmentsTransform
            ->transform($listDepartments);
    }
}