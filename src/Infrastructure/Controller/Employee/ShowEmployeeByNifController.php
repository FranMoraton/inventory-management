<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Inventory\Management\Application\Employee\ShowEmployeeByNif\ShowEmployeeByNif;
use Inventory\Management\Application\Employee\ShowEmployeeByNif\ShowEmployeeByNifCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowEmployeeByNifController extends Controller
{
    public function showEmployeeByNif(Request $request, ShowEmployeeByNif $showEmployeeByNif): Response
    {
        $showEmployeeByNifCommand = new ShowEmployeeByNifCommand(
            $request->attributes->get('nif')
        );
        $response = $showEmployeeByNif->handle($showEmployeeByNifCommand);

        return $this->json($response);
    }
}
