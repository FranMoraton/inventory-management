<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\CheckLoginEmployee\CheckLoginEmployee;
use Inventory\Management\Application\Employee\CheckLoginEmployee\CheckLoginEmployeeCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginEmployeeController extends Controller
{
    public function checkLoginEmployee(Request $request, CheckLoginEmployee $checkLoginEmployee): Response
    {
        $checkLoginEmployeeCommand = new CheckLoginEmployeeCommand(
            $request->query->get('nif'),
            $request->query->get('password')
        );
        $response = $checkLoginEmployee->handle($checkLoginEmployeeCommand);

        return $this->json($response);
    }
}
