<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\UpdateNameSubDepartment\UpdateNameSubDepartment;
use Inventory\Management\Application\Department\UpdateNameSubDepartment\UpdateNameSubDepartmentCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateNameSubDepartmentController
{
    public function updateNameSubDepartment(
        Request $request,
        UpdateNameSubDepartment $updateNameSubDepartment
    ): Response {
        $updateNameSubDepartmentCommand = new UpdateNameSubDepartmentCommand(
            $request->attributes->get('subdepartment'),
            $request->query->get('name')
        );
        $response = $updateNameSubDepartment->handle($updateNameSubDepartmentCommand);

        return new JsonResponse(
            $response['data'],
            $response['code']
        );
    }
}
