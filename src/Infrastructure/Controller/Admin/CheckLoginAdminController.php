<?php

namespace Inventory\Management\Infrastructure\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CheckLoginAdminController
{
    public function checkLoginAdmin(AuthenticationUtils $authUtils): Response
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
