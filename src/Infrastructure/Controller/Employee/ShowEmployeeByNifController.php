<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\ShowEmployeeByNif\ShowEmployeeByNif;
use Inventory\Management\Application\Employee\ShowEmployeeByNif\ShowEmployeeByNifCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowEmployeeByNifController
{
    public function showEmployeeByNif(Request $request, ShowEmployeeByNif $showEmployeeByNif): Response
    {
        $showEmployeeByNifCommand = new ShowEmployeeByNifCommand(
            $request->attributes->get('nif'),
            '2$ao57Fd9.f2hfhgtykiGhkuF.GGJ9I09IvqN5'
        );
        $response = $showEmployeeByNif->handle($showEmployeeByNifCommand);

        return new JsonResponse(
            $response['data'],
            $response['code']
        );
    }
}
