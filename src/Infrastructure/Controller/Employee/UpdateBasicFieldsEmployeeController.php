<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee\UpdateBasicFieldsEmployee;
use Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee\UpdateBasicFieldsEmployeeCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateBasicFieldsEmployeeController
{
    public function updateBasicFieldsEmployee(
        Request $request,
        UpdateBasicFieldsEmployee $updateBasicFieldsEmployee
    ): Response {
        $updateBasicFieldsEmployeeCommand = new UpdateBasicFieldsEmployeeCommand(
            $request->query->get('name'),
            $request->query->get('password'),
            $request->query->get('telephone')
        );
        $response = $updateBasicFieldsEmployee->handle($updateBasicFieldsEmployeeCommand);

        return new JsonResponse(
            $response['data'],
            $response['code']
        );
    }
}
