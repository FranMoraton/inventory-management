<?php

namespace Inventory\Management\Infrastructure\Repository\Employee;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;

class EmployeeRepository extends ServiceEntityRepository
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
        return $this->changeStatusToEmployee($employee, true);
    }

    /**
     * @param Employee $employee
     * @return Employee|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function changeStatusToEnableEmployee(Employee $employee): Employee
    {
        return $this->changeStatusToEmployee($employee, false);
    }

    /**
     * @param Employee $employee
     * @param bool $status
     * @return Employee
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function changeStatusToEmployee(Employee $employee, bool $status): Employee
    {
        $employee->getEmployeeStatus()
            ->setDisabledEmployee($status);

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
