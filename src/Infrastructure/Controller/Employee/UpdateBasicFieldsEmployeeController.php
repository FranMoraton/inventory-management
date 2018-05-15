<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee\UpdateBasicFieldsEmployee;
use Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee\UpdateBasicFieldsEmployeeCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateBasicFieldsEmployeeController extends Controller
{
    public function updateBasicFieldsEmployee(
        Request $request,
        UpdateBasicFieldsEmployee $updateBasicFieldsEmployee
    ): Response {
        $updateBasicFieldsEmployeeCommand = new UpdateBasicFieldsEmployeeCommand(
            $request->attributes->get('nif'),
            $request->query->get('name'),
            $request->query->get('password'),
            $request->query->get('telephone')
        );
        $response = $updateBasicFieldsEmployee->handle($updateBasicFieldsEmployeeCommand);

        return $this->json($response);
    }
}