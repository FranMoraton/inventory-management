<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\ShowByFirstResultEmployees\ShowByFirstResultEmployees;
use Inventory\Management\Application\Employee\ShowByFirstResultEmployees\ShowByFirstResultEmployeesCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowByFirstResultEmployeesController extends Controller
{
    public function showByFirstResultEmployees(
        Request $request,
        ShowByFirstResultEmployees $showByFirstResultEmployees
    ): Response {
        $showByFirstResultEmployeesCommand = new ShowByFirstResultEmployeesCommand(
            $request->get('firstresultposition')
        );
        $response = $showByFirstResultEmployees->handle($showByFirstResultEmployeesCommand);

        return $this->json($response);
    }
}
