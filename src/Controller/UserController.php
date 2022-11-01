<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;

class UserController extends AbstractFOSRestController
{

    /**
     * @param User $user
     *
     * @ApiDoc\Operation(
     *     tags={"Users"},
     *     summary="Return user by UUID",
     *     @SWG\Parameter(name="uuid", in="path", description="User UUID", required=true, type="string"),
     *     @SWG\Response(response="200", description="If successful"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="user", class="App\Entity\User", options={"mapping" : {"uuid" : "uniqueIdentifier"}})
     *
     * @Rest\Get("/users/{uuid}")
     * @Rest\View()
     *
     * @return User
     */
    public function getUserAction(User $user): User
    {
        return $user;
    }

}