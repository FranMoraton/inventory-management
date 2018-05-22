<?php

namespace Inventory\Management\Domain\Service\Admin;

use Inventory\Management\Domain\Model\Entity\Admin\Admin;
use Inventory\Management\Domain\Model\Entity\Admin\AdminRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Admin\NotFoundAdminsException;

class SearchAdminByUsername
{
    private $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * @param string $username
     * @return Admin|null
     * @throws NotFoundAdminsException
     */
    public function execute(string $username): ?Admin
    {
        $resultAdmin = $this->adminRepository->findAdminByUsername($username);
        if (null === $resultAdmin) {
            throw new NotFoundAdminsException();
        }

        return $resultAdmin;
    }
}
