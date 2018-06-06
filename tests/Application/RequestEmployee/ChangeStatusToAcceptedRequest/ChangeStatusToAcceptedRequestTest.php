<?php

namespace Inventory\Management\tests\Application\RequestEmployee\ChangeStatusToAcceptedRequest;

use Inventory\Management\Application\RequestEmployee\ChangeStatusToAcceptedRequest\ChangeStatusToAcceptedRequest;
use Inventory\Management\Application\RequestEmployee\ChangeStatusToAcceptedRequest\ChangeStatusToAcceptedRequestTransform;
use Inventory\Management\Domain\Model\Entity\RequestEmployee\RequestEmployeeRepository;
use Inventory\Management\Domain\Service\RequestEmployee\SearchRequestEmployeeById;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ChangeStatusToAcceptedRequestTest extends TestCase
{
    /**
     * @var ChangeStatusToAcceptedRequest
     */
    private $handler;

    /**
     * @var MockObject
     */
    private $requestEmployeeRepository;

    public function setUp()
    {
        $this->requestEmployeeRepository = $this->createMock(RequestEmployeeRepository::class);

        $this->handler = new ChangeStatusToAcceptedRequest(
            $this->requestEmployeeRepository,
            new ChangeStatusToAcceptedRequestTransform(),
            new SearchRequestEmployeeById($this->requestEmployeeRepository)
        );
    }
}
