<?php

namespace Inventory\Management\Application\Department\showDepartments;

use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
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
     * @throws NotFoundDepartmentsException
     */
    public function handle(): array
    {
        $listDepartments = $this->departmentRepository->showAllDepartments();
        if (0 === count($listDepartments)) {
            throw new NotFoundDepartmentsException('No se han encontrado departamentos');
        }

        return $this->showDepartmentsTransform
            ->transform($listDepartments);
    }
}
