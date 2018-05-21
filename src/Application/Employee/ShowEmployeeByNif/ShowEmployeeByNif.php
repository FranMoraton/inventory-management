<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeByNif;

use Inventory\Management\Application\Util\JwtToken\CheckToken;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Util\Observer\ListExceptions;

class ShowEmployeeByNif
{
    private $showEmployeeByNifTransform;
    private $searchEmployeeByNif;
    private $checkToken;

    public function __construct(
        ShowEmployeeByNifTransformInterface $showEmployeeByNifTransform,
        SearchEmployeeByNif $searchEmployeeByNif,
        CheckToken $checkToken
    ) {
        $this->showEmployeeByNifTransform = $showEmployeeByNifTransform;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
        $this->checkToken = $checkToken;
        ListExceptions::instance()->restartExceptions();
        ListExceptions::instance()->attach($checkToken);
        ListExceptions::instance()->attach($searchEmployeeByNif);
    }

    public function handle(ShowEmployeeByNifCommand $showEmployeeByNifCommand)
    {
        $exceptionsToken = $this->checkToken->handle(
            $showEmployeeByNifCommand->token()
        );
        if (0 !== count($exceptionsToken)) {
            return $exceptionsToken;
        }
        $employee = $this->searchEmployeeByNif->execute(
            $showEmployeeByNifCommand->nif()
        );
        if (ListExceptions::instance()->checkForExceptions()) {
            return ListExceptions::instance()->firstException();
        }

        return [
            'data' => $this->showEmployeeByNifTransform->transform($employee),
            'code' => HttpResponses::OK
        ];
    }
}
