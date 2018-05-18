<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckLogoutEmployeeController
{
    public function checkLogoutEmployee(): Response
    {
        return new JsonResponse('Has cerrado la sesión', 200);
    }
}
