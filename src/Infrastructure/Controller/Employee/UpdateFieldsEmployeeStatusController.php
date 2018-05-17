<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus\UpdateFieldsEmployeeStatus;
use Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus\UpdateFieldsEmployeeStatusCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateFieldsEmployeeStatusController
{
    public function UpdateFieldsEmployeeStatus(
        Request $request,
        UpdateFieldsEmployeeStatus $updateFieldsEmployeeStatus
    ): Response {
        $updateFieldsEmployeeStatusCommand = new UpdateFieldsEmployeeStatusCommand(
            $request->attributes->get('nif'),
            $request->query->get('image'),
            $request->query->get('expirationcontractdate'),
            $request->query->get('possiblerenewal'),
            $request->query->get('availableholidays'),
            $request->query->get('holidayspendingtoapplyfor'),
            $request->query->get('department'),
            $request->query->get('subdepartment')
        );
        $response = $updateFieldsEmployeeStatus->handle($updateFieldsEmployeeStatusCommand);

        return new JsonResponse(
            $response['data'],
            $response['code']
        );
    }
}
