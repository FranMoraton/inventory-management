<?php

namespace Inventory\Management\Domain\Model\Entity\Admin;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class NotFoundAdminsException extends \Exception
{
    public function __construct()
    {
        $message = 'No se ha encontrado ningún administrador';
        $code = HttpResponses::NOT_FOUND;
        parent::__construct($message, $code);
    }
}
