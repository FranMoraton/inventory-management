<?php

namespace Inventory\Management\Infrastructure\Repository\Admin;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class AdminRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    /**
     * @param string $username
     * @return mixed|null|\Symfony\Component\Security\Core\User\UserInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('ad')
            ->andWhere('ad.username = :username')
            ->andWhere('ad.disabledAdmin = :disabledAdmin')
            ->setParameter('username', $username)
            ->setParameter('disabledAdmin', false)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
