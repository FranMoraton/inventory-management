<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\CreateDepartment\CreateDepartment;
use Inventory\Management\Application\Department\CreateDepartment\CreateDepartmentCommand;
use Inventory\Management\Application\Department\showDepartments\ShowDepartments;
use Inventory\Management\Application\Department\showDepartments\ShowDepartmentsTransform;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Inventory\Management\Domain\Model\Department\CanNotCreateDepartmentException
     */
    public function createDepartment(Request $request, DepartmentRepository $departmentRepository): Response
    {
        $createDepartment = new CreateDepartment($departmentRepository);
        $name = $request->query->get('name');
        $createDepartmentCommand = new CreateDepartmentCommand($name);
        $createDepartment->handle($createDepartmentCommand);

        return $this->json(['ok' => 200]);
    }

    /**
     * @return Response
     * @throws \Inventory\Management\Domain\Model\Department\NotFoundDepartmentsException
     */
    public function showAllDepartments(DepartmentRepository $departmentRepository): Response
    {
        $showDepartmentsTransform = new ShowDepartmentsTransform();
        $showDepartments = new ShowDepartments($departmentRepository, $showDepartmentsTransform);
        $response = $showDepartments->handle();

        return $this->json($response);
    }
}
