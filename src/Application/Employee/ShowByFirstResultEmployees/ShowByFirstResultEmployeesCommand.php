<?php

namespace Inventory\Management\Application\Employee\ShowByFirstResultEmployees;

use Assert\Assertion;

class ShowByFirstResultEmployeesCommand
{
    private const MIN_POSITION = 0;
    private $firstResultPosition;

    public function __construct($firstResultPosition)
    {
        Assertion::min($firstResultPosition, self::MIN_POSITION);
        $this->firstResultPosition = $firstResultPosition;
    }

    public function firstResultPosition(): int
    {
        return $this->firstResultPosition;
    }
}
