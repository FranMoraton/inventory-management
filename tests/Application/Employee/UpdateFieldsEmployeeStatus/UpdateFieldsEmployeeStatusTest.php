<?php

namespace Inventory\Management\Tests\Application\Employee\UpdateFieldsEmployeeStatus;

use Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus\UpdateFieldsEmployeeStatus;
use Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus\UpdateFieldsEmployeeStatusCommand;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\File\UploadPhoto;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;
use Inventory\Management\Infrastructure\JwtToken\JwtTokenClass;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateFieldsEmployeeStatusTest extends TestCase
{
    /* @var MockObject $employeeRepository */
    private $employeeRepository;
    /* @var MockObject $subDepartmentRepository */
    private $departmentRepository;
    /* @var MockObject $subDepartmentRepository */
    private $subDepartmentRepository;
    /* @var MockObject $jwtTokenClass */
    private $jwtTokenClass;
    /* @var MockObject $uploadPhoto */
    private $uploadPhoto;
    private $checkToken;
    private $updateFieldsEmployeeStatusCommand;

    public function setUp(): void
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->departmentRepository = $this->createMock(DepartmentRepository::class);
        $this->subDepartmentRepository = $this->createMock(SubDepartmentRepository::class);
        $this->jwtTokenClass = $this->createMock(JwtTokenClass::class);
        $this->checkToken = new CheckToken($this->jwtTokenClass);
        $this->updateFieldsEmployeeStatusCommand = new UpdateFieldsEmployeeStatusCommand(
            '75693124D',
            ['type'],
            '15-05-2018',
            '15-05-2018',
            2,
            2,
            1,
            1
        );
        $this->uploadPhoto = $this->createMock(UploadPhoto::class);
        $this->uploadPhoto->method('execute')
            ->with(['type'], Employee::URL_IMAGE)
            ->willReturn('image.jpg');
    }

    /**
     * @test
     */
    public function given_employee_status_when_nif_is_or_not_encountered_then_department_not_found_exception(): void
    {
        $idDepartment = 1;
        $nif = '75693124D';
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn(null);
        $employee = $this->createMock(Employee::class);
        $this->employeeRepository->method('findEmployeeByNif')
            ->with($nif)
            ->willReturn($employee);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $searchDepartmentById = new SearchDepartmentById($this->departmentRepository);
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $updateFieldsEmployeeStatus = new UpdateFieldsEmployeeStatus(
            $this->employeeRepository,
            $searchEmployeeByNif,
            $searchDepartmentById,
            $searchSubDepartmentById,
            $this->uploadPhoto,
            $this->checkToken
        );
        $this->expectException(NotFoundDepartmentsException::class);
        $updateFieldsEmployeeStatus->handle($this->updateFieldsEmployeeStatusCommand);
    }

    /**
     * @test
     */
    public function given_employee_status_when_nif_is_or_not_encountered_then_sub_department_not_found_exception(): void
    {
        $idDepartment = 1;
        $idSubDepartment = 1;
        $nif = '75693124D';
        $department = $this->createMock(Department::class);
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn($department);
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn(null);
        $employee = $this->createMock(Employee::class);
        $this->employeeRepository->method('findEmployeeByNif')
            ->with($nif)
            ->willReturn($employee);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $searchDepartmentById = new SearchDepartmentById($this->departmentRepository);
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $updateFieldsEmployeeStatus = new UpdateFieldsEmployeeStatus(
            $this->employeeRepository,
            $searchEmployeeByNif,
            $searchDepartmentById,
            $searchSubDepartmentById,
            $this->uploadPhoto,
            $this->checkToken
        );
        $this->expectException(NotFoundSubDepartmentsException::class);
        $updateFieldsEmployeeStatus->handle($this->updateFieldsEmployeeStatusCommand);
    }

    /**
     * @test
     */
    public function given_employee_status_when_nif_is_not_encountered_then_employee_not_found_exception(): void
    {
        $idDepartment = 1;
        $idSubDepartment = 1;
        $nif = '75693124D';
        $department = $this->createMock(Department::class);
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn($department);
        $subDepartment = $this->createMock(SubDepartment::class);
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn($subDepartment);
        $this->employeeRepository->method('findEmployeeByNif')
            ->with($nif)
            ->willReturn(null);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $searchDepartmentById = new SearchDepartmentById($this->departmentRepository);
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $updateFieldsEmployeeStatus = new UpdateFieldsEmployeeStatus(
            $this->employeeRepository,
            $searchEmployeeByNif,
            $searchDepartmentById,
            $searchSubDepartmentById,
            $this->uploadPhoto,
            $this->checkToken
        );
        $this->expectException(NotFoundEmployeesException::class);
        $updateFieldsEmployeeStatus->handle($this->updateFieldsEmployeeStatusCommand);
    }

    /**
     * @test
     */
    public function given_employee_status_when_nif_is_encountered_then_update(): void
    {
        $idDepartment = 1;
        $idSubDepartment = 1;
        $nif = '75693124D';
        $department = $this->createMock(Department::class);
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn($department);
        $subDepartment = $this->createMock(SubDepartment::class);
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn($subDepartment);
        $employeeStatus = $this->createMock(EmployeeStatus::class);
        $employee = $this->createMock(Employee::class);
        $employee->method('getId')
            ->willReturn(1);
        $employee->method('getEmployeeStatus')
            ->willReturn($employeeStatus);
        $this->employeeRepository->method('findEmployeeByNif')
            ->with($nif)
            ->willReturn($employee);
        $this->employeeRepository->method('updateFieldsEmployeeStatus')
            ->with(
                $employee,
                'image.jpg',
                new \DateTime($this->updateFieldsEmployeeStatusCommand->expirationContractDate()),
                new \DateTime($this->updateFieldsEmployeeStatusCommand->possibleRenewal()),
                $this->updateFieldsEmployeeStatusCommand->availableHolidays(),
                $this->updateFieldsEmployeeStatusCommand->holidaysPendingToApplyFor(),
                $department,
                $subDepartment
            )
            ->willReturn($employee);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $searchDepartmentById = new SearchDepartmentById($this->departmentRepository);
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $updateFieldsEmployeeStatus = new UpdateFieldsEmployeeStatus(
            $this->employeeRepository,
            $searchEmployeeByNif,
            $searchDepartmentById,
            $searchSubDepartmentById,
            $this->uploadPhoto,
            $this->checkToken
        );
        $result = $updateFieldsEmployeeStatus->handle($this->updateFieldsEmployeeStatusCommand);
        $this->assertEquals(
            [
                'data' => 'Se ha actualizado el estado del trabajador con éxito',
                'code' => 200
            ],
            $result
        );
    }
}
