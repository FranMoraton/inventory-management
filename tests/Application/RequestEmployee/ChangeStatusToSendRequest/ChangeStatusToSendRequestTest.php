<?php

namespace Inventory\management\tests\Application\RequestEmployee\ChangeStatusToSendRequest;

use Inventory\Management\Application\RequestEmployee\ChangeStatusToSendRequest\ChangeStatusToSendRequest;
use Inventory\Management\Application\RequestEmployee\ChangeStatusToSendRequest\ChangeStatusToSendRequestTransform;
use Inventory\Management\Domain\Model\Entity\RequestEmployee\RequestEmployeeRepository;
use Inventory\Management\Domain\Service\RequestEmployee\CheckRequestIsFromEmployee;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ChangeStatusToSendRequestTest extends TestCase
{
    /**
     * @var ChangeStatusToSendRequest
     */
    private $handler;

    /**
     * @var MockObject
     */
    private $requestEmployeeRepository;

    public function setUp()
    {
        $this->requestEmployeeRepository = $this->createMock(RequestEmployeeRepository::class);

        $this->handler = new ChangeStatusToSendRequest(
            $this->requestEmployeeRepository,
            new ChangeStatusToSendRequestTransform(),
            new CheckRequestIsFromEmployee($this->requestEmployeeRepository)
        );
    }
}
