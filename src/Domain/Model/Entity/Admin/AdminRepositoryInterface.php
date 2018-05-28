<?php

namespace Inventory\Management\Domain\Model\Entity\Admin;

interface AdminRepositoryInterface
{
    public function findAdminByUsername(string $username): ?Admin;
}
