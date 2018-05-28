<?php

namespace Inventory\Management\Application\Admin\CheckLoginAdmin;

use Inventory\Management\Domain\Model\Entity\Admin\AdminRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Model\JwtToken\Roles;
use Inventory\Management\Domain\Service\Admin\SearchAdminByUsername;
use Inventory\Management\Domain\Service\PasswordHash\CheckDecryptPassword;
use Inventory\Management\Domain\Service\JwtToken\CreateToken;

class CheckLoginAdmin
{
    private $adminRepository;
    private $searchAdminByUsername;
    private $checkDecryptPassword;
    private $createToken;

    public function __construct(
        AdminRepositoryInterface $adminRepository,
        SearchAdminByUsername $searchAdminByUsername,
        CheckDecryptPassword $checkDecryptPassword,
        CreateToken $createToken
    ) {
        $this->adminRepository = $adminRepository;
        $this->searchAdminByUsername = $searchAdminByUsername;
        $this->checkDecryptPassword = $checkDecryptPassword;
        $this->createToken = $createToken;
    }

    /**
     * @param CheckLoginAdminCommand $checkLoginAdminCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Admin\NotFoundAdminsException
     * @throws \Inventory\Management\Domain\Model\PasswordHash\IncorrectPasswordException
     */
    public function handle(CheckLoginAdminCommand $checkLoginAdminCommand): array
    {
        $admin = $this->searchAdminByUsername->execute(
            $checkLoginAdminCommand->username()
        );
        $this->checkDecryptPassword->execute(
            $checkLoginAdminCommand->password(),
            $admin->getPassword()
        );
        $token = $this->createToken->execute(
            Roles::ROLE_ADMIN,
            [
                'id' => $admin->getId(),
                'username' => $admin->getUsername()
            ]
        );

        return [
            'data' => $token,
            'code' => HttpResponses::OK
        ];
    }
}
