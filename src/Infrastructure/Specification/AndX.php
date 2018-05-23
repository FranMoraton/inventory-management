<?php

namespace Inventory\Management\Infrastructure\Specification;

use Doctrine\ORM\QueryBuilder;
use Inventory\Management\Domain\Model\Specification\Specification;

class AndX implements Specification
{
    private $children;

    public function __construct()
    {
        $this->children = func_get_args();
    }

    public function match(QueryBuilder $qb)
    {
        return call_user_func_array(
            array($qb->expr(), 'andX'),
            array_map(
                function ($specification) use ($qb) {
                    return $specification->match($qb);
                },
                $this->children
            )
        );
    }
}
