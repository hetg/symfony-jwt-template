<?php

namespace App\Command;

use App\Utils\UserManipulator;

class CreateUserCommand extends \FOS\UserBundle\Command\CreateUserCommand
{

    public function __construct(UserManipulator $userManipulator)
    {
        parent::__construct($userManipulator);
    }

}