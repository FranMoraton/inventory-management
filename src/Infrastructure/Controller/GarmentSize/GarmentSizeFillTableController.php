<?php
/**
 * Created by PhpStorm.
 * User: programador
 * Date: 16/05/18
 * Time: 8:31
 */

namespace Inventory\Management\Infrastructure\Controller\GarmentSize;


use Inventory\Management\Application\GarmentSize\CreateGarmentSizeTable\CreateGarmentSizeTable;
use Inventory\Management\Application\GarmentSize\CreateGarmentSizeTable\CreateGarmentSizeTableCommand;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Symfony\Component\HttpFoundation\JsonResponse;

class GarmentSizeFillTableController
{
    private $handler;

    /**
     * GarmentSizeFillTableController constructor.
     * @param $handler
     */
    public function __construct(CreateGarmentSizeTable $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke()
    {
        $response = $this->handler->handle(new CreateGarmentSizeTableCommand());

        return new JsonResponse($response["data"],$response["code"]);
    }
}