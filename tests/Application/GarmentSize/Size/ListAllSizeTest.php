<?php

namespace Inventory\Management\Tests\Application\GarmentSize\Size;

use Inventory\Management\Application\GarmentSize\Size\ListAllSize\ListAllSize;
use Inventory\Management\Application\GarmentSize\Size\ListAllSize\ListAllSizeCommand;
use Inventory\Management\Application\GarmentSize\Size\ListAllSize\ListAllSizeTransform;
use Inventory\Management\Domain\Model\Entity\GarmentSize\Size\SizeRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ListAllSizeTest extends TestCase
{
    /**
     * @var ListAllSize
     */
    private $handler;
    /**
     * @var MockObject
     */
    private $sizeRepositoryStub;

    public function setUp()
    {
        $this->sizeRepositoryStub = $this->createMock(SizeRepositoryInterface::class);
        $this->handler = new ListAllSize($this->sizeRepositoryStub, new ListAllSizeTransform());
    }

    /**
     * @test
     */
    public function given_a_call_to_listall_when_handle_then_succes()
    {
        $this->sizeRepositoryStub->method('findAllSize')->willReturn(array());
        $this->handler->handle(new ListAllSizeCommand());
        $this->assertTrue(true, true);
    }
}
