<?php

namespace App\DTO;

use App\DTO\Interfaces\RequestDTOInterface;
use App\DTO\Interfaces\ValidatedDTOInterface;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto implements RequestDTOInterface, ValidatedDTOInterface
{
    /**
     * @JMS\Type(name="string")
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @Assert\Email()
     */
    public string $email;

    /**
     * @JMS\Type(name="string")
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    public string $username;

    /**
     * @JMS\Type(name="string")
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    public string $password;

}