<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Type(name="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="unique_identifier", type="string", length=255, unique=true, nullable=false)
     */
    protected string $uniqueIdentifier;

    /**
     * @return string
     */
    public function getUniqueIdentifier(): string
    {
        return $this->uniqueIdentifier;
    }

    /**
     * @param string $uniqueIdentifier
     *
     * @return User
     */
    public function setUniqueIdentifier(string $uniqueIdentifier): User
    {
        $this->uniqueIdentifier = $uniqueIdentifier;

        return $this;
    }
}