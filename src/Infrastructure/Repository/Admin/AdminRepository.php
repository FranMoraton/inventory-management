<?php

namespace Inventory\Management\Infrastructure\Repository\Admin;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Inventory\Management\Domain\Model\Entity\Admin\Admin;
use Inventory\Management\Domain\Model\Entity\Admin\AdminRepositoryInterface;

class AdminRepository extends ServiceEntityRepository implements AdminRepositoryInterface
{
    public function findAdminByUsername(string $username): ?Admin
    {
        /* @var Admin $admin */
        $admin = $this->findOneBy(['username' => $username, 'disabledAdmin' => false]);

        return $admin;
    }
}
