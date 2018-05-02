<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartment;
use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartmentCommand;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubDepartmentController extends Controller
{
    /**
     * @param Request $request
     * @param DepartmentRepository $departmentRepository
     * @param SubDepartmentRepository $subDepartmentRepository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createSubDepartment(
        Request $request,
        DepartmentRepository $departmentRepository,
        SubDepartmentRepository $subDepartmentRepository
    ): Response {
        $createSubDepartment = new CreateSubDepartment($departmentRepository, $subDepartmentRepository);
        $department = $request->get('department');
        $name = $request->query->get('name');
        $createSubDepartmentCommand = new CreateSubDepartmentCommand($department, $name);
        $createSubDepartment->handle($createSubDepartmentCommand);

        return $this->json(['ok' => 200]);
    }
}
