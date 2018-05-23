<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\ShowByFirstResultEmployees\ShowByFirstResultEmployees;
use Inventory\Management\Application\Employee\ShowByFirstResultEmployees\ShowByFirstResultEmployeesCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowByFirstResultEmployeesController
{
    public function showByFirstResultEmployees(
        Request $request,
        ShowByFirstResultEmployees $showByFirstResultEmployees
    ): Response {
        $showByFirstResultEmployeesCommand = new ShowByFirstResultEmployeesCommand(
            $request->attributes->get('firstresultposition'),
            $request->query->get('name'),
            $request->query->get('code'),
            $request->query->get('department'),
            $request->query->get('subdepartment')
        );
        $response = $showByFirstResultEmployees->handle($showByFirstResultEmployeesCommand);

        return new JsonResponse(
            $response['data'],
            $response['code']
        );
    }
}
