<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity
 * @ORM\Table(name = "users")
 */
class Users
{
    /**
     * @ORM\Column(type = "integer", name = "id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $userId;

    /**
     * @ORM\Column(type = "string", length = 512)
     */
    private $email;

    /**
     * @ORM\Column(type = "string", length = 64)
     */
    private $password;

    /**
     * Get userId.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

}
