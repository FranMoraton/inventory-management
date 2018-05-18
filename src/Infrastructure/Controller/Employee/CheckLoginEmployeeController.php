<?php

namespace Inventory\Management\Infrastructure\Controller\Employee;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CheckLoginEmployeeController
{
    public function checkLoginEmployee(AuthenticationUtils $authUtils): Response
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUser = $authUtils->getLastUsername();
        $list = [
            'error' => $error,
            'lastUser' => $lastUser
        ];

        return new JsonResponse($list, 200);
    }
}
