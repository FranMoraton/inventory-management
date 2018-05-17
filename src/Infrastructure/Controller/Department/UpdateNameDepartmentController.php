<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\UpdateNameDepartment\UpdateNameDepartment;
use Inventory\Management\Application\Department\UpdateNameDepartment\UpdateNameDepartmentCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateNameDepartmentController
{
    public function updateNameDepartment(Request $request, UpdateNameDepartment $updateNameDepartment): Response
    {
        $updateNameDepartmentCommand = new UpdateNameDepartmentCommand(
            $request->attributes->get('department'),
            $request->query->get('name')
        );
        $response = $updateNameDepartment->handle($updateNameDepartmentCommand);

        return new JsonResponse(
            $response['data'],
            $response['code']
        );
    }
}
