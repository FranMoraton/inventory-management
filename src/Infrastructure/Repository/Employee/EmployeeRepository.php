<?php

namespace Inventory\Management\Infrastructure\Repository\Employee;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Infrastructure\Specification\AndX;
use Inventory\Management\Infrastructure\Specification\AsArray;
use Inventory\Management\Infrastructure\Specification\Employee\FilterEmployeeByCode;
use Inventory\Management\Infrastructure\Specification\Employee\FilterEmployeeByDepartment;
use Inventory\Management\Infrastructure\Specification\Employee\FilterEmployeeByName;
use Inventory\Management\Infrastructure\Specification\Employee\FilterEmployeeBySubDepartment;

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
     * @param string $name
     * @param string $telephone
     * @return Employee
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateBasicFieldsEmployee(
        Employee $employee,
        string $passwordHash,
        string $name,
        string $telephone
    ): Employee {
        $employee->setPassword($passwordHash);
        $employee->setName($name);
        $employee->setTelephone($telephone);
        $this->getEntityManager()->flush();

        return $employee;
    }

    /**
     * @param Employee $employee
     * @param string $image
     * @param \DateTime $expirationContractDate
     * @param \DateTime $possibleRenewal
     * @param int $availableHolidays
     * @param int $holidaysPendingToApplyFor
     * @param Department $department
     * @param SubDepartment $subDepartment
     * @return Employee
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateFieldsEmployeeStatus(
        Employee $employee,
        string $image,
        \DateTime $expirationContractDate,
        \DateTime $possibleRenewal,
        int $availableHolidays,
        int $holidaysPendingToApplyFor,
        Department $department,
        SubDepartment $subDepartment
    ): Employee {
        $employee->setImage($image);
        $employeeStatus = $employee->getEmployeeStatus();
        $employeeStatus->setExpirationContractDate($expirationContractDate);
        $employeeStatus->setPossibleRenewal($possibleRenewal);
        $employeeStatus->setAvailableHolidays($availableHolidays);
        $employeeStatus->setHolidaysPendingToApplyFor($holidaysPendingToApplyFor);
        $employeeStatus->setDepartment($department);
        $employeeStatus->setSubDepartment($subDepartment);
        $this->getEntityManager()->flush();

        return $employee;
    }

    /**
     * @param string $nif
     * @return Employee|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findEmployeeByNif(string $nif): ?Employee
    {
        /* @var Employee $employee */
        $employee = $this->createQueryBuilder('em')
            ->innerJoin('em.employeeStatus', 'ems')
            ->andWhere('em.nif = :nif')
            ->andWhere('ems.disabledEmployee = :disabledEmployee')
            ->setParameter('nif', $nif)
            ->setParameter('disabledEmployee', false)
            ->getQuery()
            ->getOneOrNullResult();

        return $employee;
    }

    public function showByFirstResultFilterEmployees(
        int $initialResult,
        $name,
        $code,
        $department,
        $subDepartment
    ): array {
        $query = $this->createQueryBuilder('em')
            ->innerJoin('em.employeeStatus', 'ems')
            ->setFirstResult($initialResult)
            ->setMaxResults(self::MAX_RESULTS_QUERY);
        $specification = new AsArray(
            new AndX(
                new FilterEmployeeByName($name),
                new FilterEmployeeByCode($code),
                new FilterEmployeeByDepartment($department),
                new FilterEmployeeBySubDepartment($subDepartment)
            )
        );
        $specification->match($query);

        return $query->getQuery()->execute();
    }

    public function checkNotExistsInSsNumberEmployee(string $inSsNumber): ?Employee
    {
        /* @var Employee $employee */
        $employee = $this->findOneBy(['inSsNumber' => $inSsNumber]);

        return $employee;
    }

    /**
     * @param string $telephone
     * @param string $nif
     * @return Employee|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function checkNotExistsTelephoneEmployee(string $telephone, string $nif): ?Employee
    {
        $query = $this->createQueryBuilder('em')
            ->andWhere('em.telephone = :telephone')
            ->andWhere('em.nif != :nif')
            ->setParameter('telephone', $telephone)
            ->setParameter('nif', $nif)
            ->getQuery();
        /* @var Employee $employee */
        $employee = $query->getOneOrNullResult();

        return $employee;
    }
}
