<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\CreateDepartment\CreateDepartment;
use Inventory\Management\Application\Department\CreateDepartment\CreateDepartmentCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateDepartmentController extends Controller
{
    public function createDepartment(Request $request, CreateDepartment $createDepartment): Response
    {
        $createDepartmentCommand = new CreateDepartmentCommand(
            $request->query->get('name')
        );
        $response = $createDepartment->handle($createDepartmentCommand);

        return $this->json($response);
    }
}
