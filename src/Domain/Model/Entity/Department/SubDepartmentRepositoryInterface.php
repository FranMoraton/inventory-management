<?php

namespace Inventory\Management\Domain\Model\Entity\Department;

interface SubDepartmentRepositoryInterface
{
    public function createSubDepartment(SubDepartment $subDepartment): SubDepartment;
    public function updateNameSubDepartment(SubDepartment $subDepartment, string $name): SubDepartment;
    public function findSubDepartmentById(int $idSubDepartment): ?SubDepartment;
    public function checkNotExistNameSubDepartment($name): ?SubDepartment;
}
