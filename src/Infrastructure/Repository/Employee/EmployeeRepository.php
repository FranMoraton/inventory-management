<?php

namespace Inventory\Management\Infrastructure\Repository\Employee;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Inventory\Management\Application\Employee\UpdateBasicFieldsEmployee\UpdateBasicFieldsEmployeeCommand;
use Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus\UpdateFieldsEmployeeStatus;
use Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus\UpdateFieldsEmployeeStatusCommand;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;

class EmployeeRepository extends ServiceEntityRepository implements EmployeeRepositoryInterface
{
    private const MAX_RESULTS_QUERY = 20;

    /**
     * @param Employee $employee
     * @return Employee
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createEmployee(Employee $employee): Employee
    {
        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();

        return $employee;
    }

    /**
     * @param Employee $employee
     * @return Employee|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function changeStatusToDisableEmployee(Employee $employee): Employee
    {
        $employee->getEmployeeStatus()
            ->setDisabledEmployee(true);

        $this->getEntityManager()->flush();

        return $employee;
    }

    /**
     * @param Employee $employee
     * @return Employee|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function changeStatusToEnableEmployee(Employee $employee): Employee
    {
        $employee->getEmployeeStatus()
            ->setDisabledEmployee(false);

        $this->getEntityManager()->flush();

        return $employee;
    }

    /**
     * @param Employee $employee
     * @param string $passwordHash
     * @param UpdateBasicFieldsEmployeeCommand $updateBasicFieldsEmployeeCommand
     * @return Employee
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateBasicFieldsEmployee(
        Employee $employee,
        string $passwordHash,
        UpdateBasicFieldsEmployeeCommand $updateBasicFieldsEmployeeCommand
    ): Employee {
        $employee->setPassword($passwordHash);
        $employee->setName($updateBasicFieldsEmployeeCommand->name());
        $employee->setTelephone($updateBasicFieldsEmployeeCommand->telephone());
        $this->getEntityManager()->flush();

        return $employee;
    }

    /**
     * @param Employee $employee
     * @param string $image
     * @param UpdateFieldsEmployeeStatusCommand $updateFieldsEmployeeStatusCommand
     * @return Employee
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateFieldsEmployeeStatus(
        Employee $employee,
        string $image,
        UpdateFieldsEmployeeStatusCommand $updateFieldsEmployeeStatusCommand
    ): Employee {
        $employee->setImage($image);
        $employeeStatus = $employee->getEmployeeStatus();
        $employeeStatus->setAvailableHolidays($updateFieldsEmployeeStatusCommand->availableHolidays());
        $employeeStatus->setHolidaysPendingToApplyFor($updateFieldsEmployeeStatusCommand->holidaysPendingToApplyFor());
        $this->getEntityManager()->flush();

        return $employee;
    }

    public function findEmployeeByNif(string $nif): ?Employee
    {
        /* @var Employee $employee */
        $employee = $this->findOneBy(['nif' => $nif]);

        return $employee;
    }

    public function showByFirstResultEmployees(int $initialResult): array
    {
        $query = $this->createQueryBuilder('em')
            ->setFirstResult($initialResult)
            ->setMaxResults(self::MAX_RESULTS_QUERY)
            ->getQuery();

        return $query->execute();
    }

    public function checkNotExistsNifEmployee(string $nif): ?Employee
    {
        /* @var Employee $employee */
        $employee = $this->findOneBy(['nif' => $nif]);

        return $employee;
    }

    public function checkNotExistsInSsNumberEmployee(string $inSsNumber): ?Employee
    {
        /* @var Employee $employee */
        $employee = $this->findOneBy(['inSsNumber' => $inSsNumber]);

        return $employee;
    }

    public function checkNotExistsTelephoneEmployee(string $telephone): ?Employee
    {
        /* @var Employee $employee */
        $employee = $this->findOneBy(['telephone' => $telephone]);

        return $employee;
    }
}
