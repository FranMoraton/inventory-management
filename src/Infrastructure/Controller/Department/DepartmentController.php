<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\CreateDepartment\CreateDepartment;
use Inventory\Management\Application\Department\CreateDepartment\CreateDepartmentCommand;
use Inventory\Management\Application\Department\CreateDepartment\CreateDepartmentTransform;
use Inventory\Management\Application\Department\showDepartments\ShowDepartments;
use Inventory\Management\Application\Department\showDepartments\ShowDepartmentsTransform;
use Inventory\Management\Domain\Model\Entity\Department\Department;
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
     * @throws \Inventory\Management\Domain\Model\Department\NotCreatedDepartmentException
     */
    public function createDepartment(Request $request, DepartmentRepository $departmentRepository): Response
    {
        //$departmentRepository = $this->getDoctrine()->getRepository(Department::class);
        $createDepartmentTransform = new CreateDepartmentTransform();
        $createDepartment = new CreateDepartment($departmentRepository, $createDepartmentTransform);
        $name = $request->query->get('name');
        $createDepartmentCommand = new CreateDepartmentCommand($name);
        $response = $createDepartment->handle($createDepartmentCommand);

        return $this->json($response);
    }

    /**
     * @return Response
     * @throws \Inventory\Management\Domain\Model\Department\NotFoundDepartmentsException
     */
    public function showAllDepartments(DepartmentRepository $departmentRepository): Response
    {
        //$departmentRepository = $this->getDoctrine()->getRepository(Department::class);
        $showDepartmentsTransform = new ShowDepartmentsTransform();
        $showDepartments = new ShowDepartments($departmentRepository, $showDepartmentsTransform);
        $response = $showDepartments->handle();

        return $this->json($response);
    }
}
