<?php

namespace Inventory\Management\Infrastructure\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckLogoutAdminController
{
    public function checkLogoutAdmin(): Response
    {
        return new JsonResponse('Has cerrado la sesión', 200);
    }
}
