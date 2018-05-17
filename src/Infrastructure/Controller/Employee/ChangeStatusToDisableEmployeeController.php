<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee\ChangeStatusToDisableEmployee;
use Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee\ChangeStatusToDisableEmployeeCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeStatusToDisableEmployeeController
{
    public function changeStatusToDisableEmployee(
        Request $request,
        ChangeStatusToDisableEmployee $changeStatusToDisableEmployee
    ): Response {
        $changeStatusToDisableEmployeeCommand = new ChangeStatusToDisableEmployeeCommand(
            $request->attributes->get('nif')
        );
        $response = $changeStatusToDisableEmployee->handle($changeStatusToDisableEmployeeCommand);

        return new JsonResponse(
            $response['data'],
            $response['code']
        );
    }
}
