<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\ShowDataEmployee\ShowDataEmployee;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowDataEmployeeController
{
    public function showDataEmployee(ShowDataEmployee $showDataEmployee): Response
    {
        $response = $showDataEmployee->handle();
        
        return new JsonResponse(
            $response['data'],
            $response['code']
        );
    }
}
