<?php

namespace Inventory\Management\Domain\Model\Entity\Admin;

interface AdminRepositoryInterface
{
    public function updateTokenAdmin(Admin $admin, string $token): Admin;
    public function findAdminByUsername(string $username): ?Admin;
}
