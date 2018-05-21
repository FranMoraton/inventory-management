<?php

namespace Inventory\Management\Domain\Util\Observer;

class ListExceptions implements Observable
{
    private static $instance;

    /* @var Observer[] $observers */
    private $observers;
    private $exceptions;

    private function __construct()
    {
        $this->observers = [];
        $this->exceptions = [];
    }

    public static function instance(): ListExceptions
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function restartExceptions()
    {
        $this->observers = [];
        $this->exceptions = [];
    }

    public function checkForExceptions()
    {
        return 0 !== count($this->exceptions);
    }

    public function firstException()
    {
        return $this->exceptions[0];
    }

    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer)
    {
        $key = spl_object_hash($observer);
        if (null !== $key) {
            unset($this->observers[$key]);
        }
    }

    public function notify()
    {
        $this->exceptions = [];
        foreach ($this->observers as $observer) {
            try {
                $observer->update();
            } catch (\Exception $exception) {
                $this->exceptions[] = [
                    'data' => $exception->getMessage(),
                    'code' => $exception->getCode()
                ];
            }
        }
    }
}
