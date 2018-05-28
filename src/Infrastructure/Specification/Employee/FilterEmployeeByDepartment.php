<?php

namespace Inventory\Management\Infrastructure\Specification\Employee;

use Doctrine\ORM\QueryBuilder;
use Inventory\Management\Domain\Model\Specification\Specification;

class FilterEmployeeByDepartment implements Specification
{
    private $department;

    public function __construct(?int $department)
    {
        $this->department = $department;
    }

    public function match(QueryBuilder $qb)
    {
        if (null !== $this->department && 0 !== $this->department) {
            $qb->andWhere('ems.department = :department');
            $qb->setParameter('department', $this->department);
        }

        return $qb->expr()->eq('ems.department', ':department');
    }
}
