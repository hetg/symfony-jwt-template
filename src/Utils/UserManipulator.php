<?php

namespace App\Utils;

use App\Entity\User;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class UserManipulator extends \FOS\UserBundle\Util\UserManipulator
{

    protected EventDispatcherInterface $dispatcher;

    protected UserManagerInterface $userManager;

    protected RequestStack $requestStack;

    protected UuidGenerator $uuidGenerator;

    public function __construct(UserManagerInterface $userManager, EventDispatcherInterface $dispatcher, RequestStack $requestStack, UuidGenerator $uuidGenerator)
    {
        $this->userManager = $userManager;
        $this->dispatcher = $dispatcher;
        $this->requestStack = $requestStack;
        $this->uuidGenerator = $uuidGenerator;

        parent::__construct($userManager, $dispatcher, $requestStack);
    }

    public function create($username, $password, $email, $active, $superadmin): User
    {
        /**
         * @var User $user
         */
        $user = $this->userManager->createUser();
        $user->setUsername($username);
        $user->setUniqueIdentifier($this->uuidGenerator->generateUniqueIdentifier());
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled((bool)$active);
        $user->setSuperAdmin((bool)$superadmin);
        $this->userManager->updateUser($user);

        $event = new UserEvent($user, $this->requestStack->getCurrentRequest());
        $this->dispatcher->dispatch(FOSUserEvents::USER_CREATED, $event);

        return $user;
    }

}