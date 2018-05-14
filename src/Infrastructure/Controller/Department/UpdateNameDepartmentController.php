<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\UpdateNameDepartment\UpdateNameDepartment;
use Inventory\Management\Application\Department\UpdateNameDepartment\UpdateNameDepartmentCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateNameDepartmentController extends Controller
{
    public function updateNameDepartment(Request $request, UpdateNameDepartment $updateNameDepartment): Response
    {
        $updateNameDepartmentCommand = new UpdateNameDepartmentCommand(
            $request->get('department'),
            $request->query->get('name')
        );
        $response = $updateNameDepartment->handle($updateNameDepartmentCommand);

        return $this->json($response);
    }
}
