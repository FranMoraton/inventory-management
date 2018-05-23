<?php

namespace Inventory\Management\Domain\Model\Specification;

use Doctrine\ORM\QueryBuilder;

interface Specification
{
    public function match(QueryBuilder $qb);
}
