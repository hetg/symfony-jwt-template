<?php

namespace App\Service;

use App\DTO\UserDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use \FOS\UserBundle\Doctrine\UserManager as BaseUserManager;
use FOS\UserBundle\Util\CanonicalFieldsUpdater;
use FOS\UserBundle\Util\PasswordUpdaterInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserManager extends BaseUserManager
{

    public function __construct(
        PasswordUpdaterInterface $passwordUpdater,
        CanonicalFieldsUpdater $canonicalFieldsUpdater,
        EntityManagerInterface $entityManager,
        string $class = User::class
    )
    {
        parent::__construct($passwordUpdater, $canonicalFieldsUpdater, $entityManager, $class);
    }

    /**
     * Register user method
     *
     * @param UserDto $userDto
     *
     * @return User
     * @throws HttpException
     */
    public function register(UserDto $userDto): User
    {
        $username = $this->objectManager->getRepository(User::class)->findOneBy(['username' => $userDto->username]);
        if (null !== $username){
            throw new HttpException(409, sprintf("User with username '%s' already exists", $userDto->username));
        }

        $email = $this->objectManager->getRepository(User::class)->findOneBy(['email' => $userDto->email]);
        if (null !== $email){
            throw new HttpException(409, sprintf("User with email '%s' already exists", $userDto->email));
        }

        $user = $this->createUser();
        $user->setUserIdentifier($this->generateUserIdentifier());
        $user->setUsername($userDto->username);
        $user->setEmail($userDto->email);
        $user->setPlainPassword($userDto->password);
        $user->setEnabled(true);

        $this->updateUser($user);

        return $user;
    }

    /**
     * Generate random user identifier value by length value.
     *
     * @param int $length
     *
     * @return string
     */
    public function generateUserIdentifier($length = User::USER_IDENTIFIER_LENGTH)
    {
        $result = substr(preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes($length + 1))), 0, $length);

        return $result;
    }
}