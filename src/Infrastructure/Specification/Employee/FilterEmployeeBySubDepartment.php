<?php

namespace Inventory\Management\Infrastructure\Specification\Employee;

use Doctrine\ORM\QueryBuilder;
use Inventory\Management\Domain\Model\Specification\Specification;

class FilterEmployeeBySubDepartment implements Specification
{
    private $subDepartment;

    public function __construct(?int $subDepartment)
    {
        $this->subDepartment = $subDepartment;
    }

    public function match(QueryBuilder $qb)
    {
        if (null !== $this->subDepartment && 0 !== $this->subDepartment) {
            $qb->andWhere('ems.subDepartment = :subDepartment');
            $qb->setParameter('subDepartment', $this->subDepartment);
        }

        return $qb->expr()->eq('ems.subDepartment', ':subDepartment');
    }
}
