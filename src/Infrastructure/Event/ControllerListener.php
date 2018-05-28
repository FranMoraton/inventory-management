<?php

namespace Inventory\Management\Infrastructure\Event;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ControllerListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        if (0 === strpos($event->getRequest()->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($event->getRequest()->getContent(), true);
            foreach ($data as $type => $parameters) {
                switch ($type) {
                    case 'request':
                        $event->getRequest()->request->replace($data['request']);
                        break;
                    case 'files':
                        $event->getRequest()->files->replace($data['files']);
                }
            }
        }
    }
}
