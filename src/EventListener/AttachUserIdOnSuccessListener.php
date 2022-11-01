<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AttachUserIdOnSuccessListener
{
    public function attachUserId(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $data['uuid'] = $user->getUniqueIdentifier();

        $event->setData($data);
    }
}
