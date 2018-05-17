<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\showDepartments\ShowDepartments;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowDepartmentsController
{
    public function showDepartments(ShowDepartments $showDepartments): Response
    {
        $response = $showDepartments->handle();

        return new JsonResponse(
            $response['data'],
            $response['code']
        );
    }
}
