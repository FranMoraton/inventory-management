<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\UpdateNameSubDepartment\UpdateNameSubDepartment;
use Inventory\Management\Application\Department\UpdateNameSubDepartment\UpdateNameSubDepartmentCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateNameSubDepartmentController extends Controller
{
    public function updateNameSubDepartment(
        Request $request,
        UpdateNameSubDepartment $updateNameSubDepartment
    ): Response {
        $updateNameSubDepartmentCommand = new UpdateNameSubDepartmentCommand(
            $request->get('subdepartment'),
            $request->query->get('name')
        );
        $response = $updateNameSubDepartment->handle($updateNameSubDepartmentCommand);

        return $this->json($response);
    }
}
