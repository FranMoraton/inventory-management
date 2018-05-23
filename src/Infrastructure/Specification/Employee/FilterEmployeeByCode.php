<?php

namespace Inventory\Management\Infrastructure\Specification\Employee;

use Doctrine\ORM\QueryBuilder;
use Inventory\Management\Domain\Model\Specification\Specification;

class FilterEmployeeByCode implements Specification
{
    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function match(QueryBuilder $qb)
    {
        if (null !== $this->code && '' !== $this->code) {
            $qb->andWhere('ems.codeEmployee = :codeEmployee');
            $qb->setParameter('codeEmployee', $this->code);
        }

        return $qb->expr()->eq('ems.codeEmployee', ':codeEmployee');
    }
}
