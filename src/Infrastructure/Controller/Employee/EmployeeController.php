<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\CreateEmployee\CreateEmployee;
use Inventory\Management\Application\Employee\CreateEmployee\CreateEmployeeCommand;
use Inventory\Management\Application\Employee\CreateEmployee\CreateEmployeeTransform;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createEmployee(Request $request): Response
    {
        $employeeRepository = $this->getDoctrine()->getRepository(Employee::class);
        $employeeStatusRepository = $this->getDoctrine()->getRepository(EmployeeStatus::class);
        $subDepartmentRepository = $this->getDoctrine()->getRepository(SubDepartment::class);
        $createEmployeeTransform = new CreateEmployeeTransform();
        $createEmployee = new CreateEmployee($employeeRepository, $employeeStatusRepository,
            $subDepartmentRepository, $createEmployeeTransform);
        $createEmployeeCommand = new CreateEmployeeCommand(
            $request->query->get('image'),
            $request->query->get('nif'),
            $request->query->get('password'),
            $request->query->get('name'),
            $request->query->get('in_ss_number'),
            $request->query->get('telephone'),
            $request->query->get('first_contract_date'),
            $request->query->get('seniority_date'),
            $request->query->get('sub_department')
        );
        $response = $createEmployee->handle($createEmployeeCommand);

        return $this->json($response);
    }
}
