<?php
namespace Inventory\Management\tests\Application\RequestEmployee\ChangeStatusToDeletedRequest;

use Inventory\Management\Application\RequestEmployee\ChangeStatusToDeletedRequest\ChangeStatusToDeletedRequest;
use Inventory\Management\Application\RequestEmployee\ChangeStatusToDeletedRequest\ChangeStatusToDeletedRequestTransform;
use Inventory\Management\Domain\Model\Entity\GarmentSize\GarmentSizeRepository;
use Inventory\Management\Domain\Model\Entity\RequestEmployee\RequestEmployeeRepository;
use Inventory\Management\Domain\Service\GarmentSize\IncreaseStockGarmentSize;
use Inventory\Management\Domain\Service\RequestEmployee\CheckRequestIsFromEmployee;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ChangeStatusToDeletedRequestTest extends TestCase
{
    /**
     * @var ChangeStatusToDeletedRequest
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

        $this->handler = new ChangeStatusToDeletedRequest(
            $this->requestEmployeeRepository,
            new ChangeStatusToDeletedRequestTransform(),
            new CheckRequestIsFromEmployee($this->requestEmployeeRepository),
            new IncreaseStockGarmentSize($this->garmentSizeRepository)
        );
    }
}
