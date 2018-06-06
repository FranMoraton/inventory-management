<?php

namespace Inventory\Management\tests\Application\RequestEmployee\ChangeStatusToDeniedRequest;

use Inventory\Management\Application\RequestEmployee\ChangeStatusToDeniedRequest\ChangeStatusToDeniedRequest;
use Inventory\Management\Application\RequestEmployee\ChangeStatusToDeniedRequest\ChangeStatusToDeniedRequestTransform;
use Inventory\Management\Domain\Model\Entity\GarmentSize\GarmentSizeRepository;
use Inventory\Management\Domain\Model\Entity\RequestEmployee\RequestEmployeeRepository;
use Inventory\Management\Domain\Service\GarmentSize\IncreaseStockGarmentSize;
use Inventory\Management\Domain\Service\RequestEmployee\SearchRequestEmployeeById;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ChangeStatusToDeniedRequestTest extends TestCase
{
    /**
     * @var ChangeStatusToDeniedRequest
     */
    private $handler;

    /**
     * @var MockObject
     */
    private $requestEmployeeRepository;

    /**
     * @var MockObject
     */
    private $garmentSizeRepository;

    public function setUp()
    {
        $this->requestEmployeeRepository = $this->createMock(RequestEmployeeRepository::class);
        $this->garmentSizeRepository = $this->createMock(GarmentSizeRepository::class);

        $this->handler = new ChangeStatusToDeniedRequest(
            $this->requestEmployeeRepository,
            new ChangeStatusToDeniedRequestTransform(),
            new SearchRequestEmployeeById($this->requestEmployeeRepository),
            new IncreaseStockGarmentSize($this->garmentSizeRepository)
        );
    }
}
