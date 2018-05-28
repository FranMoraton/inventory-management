<?php

namespace Inventory\Management\Infrastructure\Specification\Employee;

use Doctrine\ORM\QueryBuilder;
use Inventory\Management\Domain\Model\Specification\Specification;

class FilterEmployeeByName implements Specification
{
    private $name;

    public function __construct(?string $name)
    {
        $this->name = $name;
    }

    public function match(QueryBuilder $qb)
    {
        if (null !== $this->name && '' !== $this->name) {
            $qb->andWhere('em.name = :name');
            $qb->setParameter('name', $this->name);
        }

        return $qb->expr()->eq('em.name', ':name');
    }
}
