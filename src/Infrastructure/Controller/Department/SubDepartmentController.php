<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartment;
use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartmentCommand;
use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartmentTransform;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubDepartmentController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Inventory\Management\Domain\Model\Department\NotCreatedDepartmentException
     */
    public function createSubDepartment(Request $request, DepartmentRepository $departmentRepository,
                                        SubDepartmentRepository $subDepartmentRepository): Response
    {
        //$departmentRepository  = $this->getDoctrine()->getRepository(Department::class);
        //$subDepartmentRepository = $this->getDoctrine()->getRepository(SubDepartment::class);
        $createSubDepartmentTransform = new CreateSubDepartmentTransform();
        $createSubDepartment = new CreateSubDepartment($departmentRepository, $subDepartmentRepository,
            $createSubDepartmentTransform);
        $department = $request->get('department');
        $name = $request->query->get('name');
        $createSubDepartmentCommand = new CreateSubDepartmentCommand($department, $name);
        $response = $createSubDepartment->handle($createSubDepartmentCommand);

        return $this->json($response);
    }
}