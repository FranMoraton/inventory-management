<?php

namespace Inventory\Management\Domain\Model\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Inventory\Management\Infrastructure\Repository\Admin\AdminRepository")
 * @ORM\Table(name="admin")
 */
class Admin implements UserInterface, \Serializable
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

    public function serialize()
    {
        return serialize(
            array(
                $this->id,
                $this->username,
                $this->password
            )
        );
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->nif,
            $this->password
        ) = unserialize(
            $serialized,
            ['allowed_classes' => false]
        );
    }

    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
