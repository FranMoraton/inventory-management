<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\ChangeStatusToEnableEmployee\ChangeStatusToEnableEmployee;
use Inventory\Management\Application\Employee\ChangeStatusToEnableEmployee\ChangeStatusToEnableEmployeeCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeStatusToEnableEmployeeController extends Controller
{
    public function changeStatusToEnableEmployee(
        Request $request,
        ChangeStatusToEnableEmployee $changeStatusToEnableEmployee
    ): Response {
        $changeStatusToEnableEmployeeCommand = new ChangeStatusToEnableEmployeeCommand(
            $request->attributes->get('nif')
        );
        $response = $changeStatusToEnableEmployee->handle($changeStatusToEnableEmployeeCommand);

        return $this->json($response);
    }
}
