<?php
/**
 * Created by PhpStorm.
 * User: programador
 * Date: 26/04/18
 * Time: 15:05
 */

namespace Inventory\Management\Domain\Model\Entity\GarmentSize\Garment;

class GarmentNotExistsException extends \Exception
{
    public function __construct()
    {
        $message = 'La prenda que quiere editar no existe';
        parent::__construct($message);
    }
}