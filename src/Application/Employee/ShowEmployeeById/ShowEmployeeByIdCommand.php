<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeById;

class ShowEmployeeByIdCommand
{
    private $nif;

    public function __construct($nif)
    {
        $this->nif = $nif;
    }

    public function nif()
    {
        return $this->nif;
    }
}
