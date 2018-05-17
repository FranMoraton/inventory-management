<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\CreateDepartment\CreateDepartment;
use Inventory\Management\Application\Department\CreateDepartment\CreateDepartmentCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateDepartmentController
{
    public function createDepartment(Request $request, CreateDepartment $createDepartment): Response
    {
        $createDepartmentCommand = new CreateDepartmentCommand(
            $request->query->get('name')
        );
        $response = $createDepartment->handle($createDepartmentCommand);

        return new JsonResponse(
            $response['data'],
            $response['code']
        );
    }
}
