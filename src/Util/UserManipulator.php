<?php

namespace App\Util;

use App\Entity\User;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class UserManipulator extends \FOS\UserBundle\Util\UserManipulator
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var UuidGenerator
     */
    protected $uuidGenerator;

    public function __construct(UserManagerInterface $userManager, EventDispatcherInterface $dispatcher, RequestStack $requestStack, UuidGenerator $uuidGenerator)
    {
        $this->userManager = $userManager;
        $this->dispatcher = $dispatcher;
        $this->requestStack = $requestStack;
        $this->uuidGenerator = $uuidGenerator;

        parent::__construct($userManager, $dispatcher, $requestStack);
    }

    public function create($username, $password, $email, $active, $superadmin)
    {
        /**
         * @var User $user
         */
        $user = $this->userManager->createUser();
        $user->setUsername($username);
        $user->setUserIdentifier($this->uuidGenerator->generateUniqueIdentifier());
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled((bool) $active);
        $user->setSuperAdmin((bool) $superadmin);
        $this->userManager->updateUser($user);

        $event = new UserEvent($user, $this->requestStack->getCurrentRequest());
        $this->dispatcher->dispatch(FOSUserEvents::USER_CREATED, $event);

        return $user;
    }

}