<?php

namespace Inventory\Management\Infrastructure\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginAdminController
{
    public function checkLoginAdmin(Request $request): Response
    {
        return new JsonResponse('', 200);
    }
}
