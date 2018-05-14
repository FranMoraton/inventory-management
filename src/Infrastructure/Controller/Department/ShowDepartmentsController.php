<?php

namespace Inventory\Management\Infrastructure\Controller\Department;

use Inventory\Management\Application\Department\showDepartments\ShowDepartments;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ShowDepartmentsController extends Controller
{
    public function showDepartments(ShowDepartments $showDepartments): Response
    {
        $response = $showDepartments->handle();

        return $this->json($response);
    }
}
