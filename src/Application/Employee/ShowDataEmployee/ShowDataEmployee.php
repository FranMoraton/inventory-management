<?php

namespace Inventory\Management\Application\Employee\ShowDataEmployee;

use Inventory\Management\Application\Util\Role\RoleEmployee;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class ShowDataEmployee extends RoleEmployee
{
    private $showDataEmployeeTransform;
    private $searchEmployeeByNif;

    public function __construct(
        ShowDataEmployeeTransformInterface $showDataEmployeeTransform,
        SearchEmployeeByNif $searchEmployeeByNif,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->showDataEmployeeTransform = $showDataEmployeeTransform;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
    }

    /**
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException
     */
    public function handle()
    {
        $employee = $this->searchEmployeeByNif->execute(
            $this->dataToken()->nif
        );

        return [
            'data' => $this->showDataEmployeeTransform->transform($employee),
            'code' => HttpResponses::OK
        ];
    }
}
