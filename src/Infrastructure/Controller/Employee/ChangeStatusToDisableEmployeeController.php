<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee\ChangeStatusToDisableEmployee;
use Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee\ChangeStatusToDisableEmployeeCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeStatusToDisableEmployeeController extends Controller
{
    public function changeStatusToDisableEmployee(
        Request $request,
        ChangeStatusToDisableEmployee $changeStatusToDisableEmployee
    ): Response {
        $changeStatusToDisableEmployeeCommand = new ChangeStatusToDisableEmployeeCommand(
            $request->attributes->get('nif')
        );
        $response = $changeStatusToDisableEmployee->handle($changeStatusToDisableEmployeeCommand);

        return $this->json($response);
    }
}
