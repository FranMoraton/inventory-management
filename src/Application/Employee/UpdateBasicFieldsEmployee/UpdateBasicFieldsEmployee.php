<?php

namespace Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee;

use Inventory\Management\Application\Util\Role\RoleEmployee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Employee\CheckNotExistTelephoneEmployee;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;
use Inventory\Management\Domain\Service\PasswordHash\EncryptPassword;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;

class UpdateBasicFieldsEmployee extends RoleEmployee
{
    private $employeeRepository;
    private $searchEmployeeByNif;
    private $checkNotExistTelephoneEmployee;
    private $encryptPassword;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        SearchEmployeeByNif $searchEmployeeByNif,
        CheckNotExistTelephoneEmployee $checkNotExistTelephoneEmployee,
        EncryptPassword $encryptPassword,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->employeeRepository = $employeeRepository;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
        $this->checkNotExistTelephoneEmployee = $checkNotExistTelephoneEmployee;
        $this->encryptPassword = $encryptPassword;
    }

    /**
     * @param UpdateBasicFieldsEmployeeCommand $updateBasicFieldsEmployeeCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\FoundTelephoneEmployeeException
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidRoleTokenException
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidTokenException
     * @throws \Inventory\Management\Domain\Model\JwtToken\InvalidUserTokenException
     */
    public function handle(UpdateBasicFieldsEmployeeCommand $updateBasicFieldsEmployeeCommand): array
    {
        $this->checkToken();
        $this->checkNotExistTelephoneEmployee->execute(
            $updateBasicFieldsEmployeeCommand->telephone(),
            $updateBasicFieldsEmployeeCommand->nif()
        );
        $employee = $this->searchEmployeeByNif->execute(
            $updateBasicFieldsEmployeeCommand->nif()
        );
        $passwordHash = $this->encryptPassword->execute(
            $updateBasicFieldsEmployeeCommand->password()
        );
        $this->employeeRepository->updateBasicFieldsEmployee(
            $employee,
            $passwordHash,
            $updateBasicFieldsEmployeeCommand->name(),
            $updateBasicFieldsEmployeeCommand->telephone()
        );

        return [
            'data' => 'Se ha actualizado el trabajador con éxito',
            'code' => HttpResponses::OK
        ];
    }
}
