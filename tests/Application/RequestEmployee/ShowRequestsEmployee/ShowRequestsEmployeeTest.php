<?php

namespace Inventory\Management\tests\Application\RequestEmployee\ShowRequestsEmployee;

use Inventory\Management\Application\RequestEmployee\ShowRequestsEmployee\ShowRequestsEmployee;
use Inventory\Management\Application\RequestEmployee\ShowRequestsEmployee\ShowRequestsEmployeeTransform;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepository;
use Inventory\Management\Domain\Model\Entity\RequestEmployee\RequestEmployeeRepository;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShowRequestsEmployeeTest extends TestCase
{
    /**
     * @var ShowRequestsEmployee
     */
    private $handler;

    /**
     * @var MockObject
     */
    private $requestEmployeeRepository;

    /**
     * @var MockObject
     */
    private $employeeRepository;

    public function setUp()
    {
        $this->requestEmployeeRepository = $this->createMock(RequestEmployeeRepository::class);
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);

        $this->handler = new ShowRequestsEmployee(
            $this->requestEmployeeRepository,
            new ShowRequestsEmployeeTransform(),
            new SearchEmployeeByNif($this->employeeRepository)
        );
    }
}
