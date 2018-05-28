<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeByNif;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class ShowEmployeeByNif extends RoleAdmin
{
    private $showEmployeeByNifTransform;
    private $searchEmployeeByNif;

    public function __construct(
        ShowEmployeeByNifTransformInterface $showEmployeeByNifTransform,
        SearchEmployeeByNif $searchEmployeeByNif,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->showEmployeeByNifTransform = $showEmployeeByNifTransform;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
    }

    /**
     * @param ShowEmployeeByNifCommand $showEmployeeByNifCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException
     */
    public function handle(ShowEmployeeByNifCommand $showEmployeeByNifCommand)
    {
        $employee = $this->searchEmployeeByNif->execute(
            $showEmployeeByNifCommand->nif()
        );

        return [
            'data' => $this->showEmployeeByNifTransform->transform($employee),
            'code' => HttpResponses::OK
        ];
    }
}
