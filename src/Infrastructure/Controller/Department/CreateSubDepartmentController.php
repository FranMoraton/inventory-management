<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartment;
use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartmentCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateSubDepartmentController
{
    public function createSubDepartment(Request $request, CreateSubDepartment $createSubDepartment): Response
    {
        $createSubDepartmentCommand = new CreateSubDepartmentCommand(
            $request->attributes->get('department'),
            $request->query->get('name')
        );
        $response = $createSubDepartment->handle($createSubDepartmentCommand);

        return new JsonResponse(
            $response['data'],
            $response['code']
        );
    }
}
