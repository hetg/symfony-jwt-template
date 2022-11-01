<?php

namespace App\DataFixtures;

use App\DTO\UserDto;
use App\Service\UserManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    private UserManager $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function load(ObjectManager $manager)
    {
        $adminDto = new UserDto();
        $adminDto->email = 'admin@admin.com';
        $adminDto->username = 'admin';
        $adminDto->password = 'admin';

        $admin = $this->userManager->register($adminDto);
        $admin->setRoles(['ROLE_SUPER_ADMIN']);

        $manager->flush();
    }
}
