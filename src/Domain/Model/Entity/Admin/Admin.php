<?php

namespace Inventory\Management\Domain\Model\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Inventory\Management\Infrastructure\Repository\Admin\AdminRepository")
 * @ORM\Table(name="admin")
 */
class Admin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=70, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default"=false})
     */
    private $disabledAdmin;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getDisabledAdmin()
    {
        return $this->disabledAdmin;
    }
}
