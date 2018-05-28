<?php

namespace Inventory\Management\Domain\Model\File;

use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;

class ImageCanNotUploadException extends \Exception
{
    public function __construct()
    {
        $message = 'No se ha podido subir la imágen';
        $code = HttpResponses::NOT_FOUND;
        parent::__construct($message, $code);
    }
}
