<?php

namespace Inventory\Management\Infrastructure\Event;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $jsonResponse = new JsonResponse(
            $exception->getMessage(),
            $exception->getCode()
        );
        $event->allowCustomResponseCode();
        $event->setResponse($jsonResponse);
    }
}
