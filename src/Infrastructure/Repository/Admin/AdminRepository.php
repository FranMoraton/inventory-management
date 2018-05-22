<?php

namespace Inventory\Management\Infrastructure\Repository\Admin;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Inventory\Management\Domain\Model\Entity\Admin\Admin;
use Inventory\Management\Domain\Model\Entity\Admin\AdminRepositoryInterface;

class AdminRepository extends ServiceEntityRepository implements AdminRepositoryInterface
{
    /**
     * @param Admin $admin
     * @param string $token
     * @return Admin
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateTokenAdmin(Admin $admin, string $token): Admin
    {
        $admin->setToken($token);
        $this->getEntityManager()->flush();

        return $admin;
    }

    public function findAdminByUsername(string $username): ?Admin
    {
        /* @var Admin $admin */
        $admin = $this->findOneBy(['username' => $username, 'disabledAdmin' => false]);

        return $admin;
    }
}
