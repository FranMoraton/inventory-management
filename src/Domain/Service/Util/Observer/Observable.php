<?php

namespace Inventory\Management\Domain\Service\Util\Observer;

interface Observable
{
    public function attach(Observer $observer);
    public function notify();
}
