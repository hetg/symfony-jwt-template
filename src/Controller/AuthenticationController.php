<?php

namespace App\Controller;

use App\DTO\UserDto;
use App\Entity\User;
use App\Service\UserManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Gesdinet\JWTRefreshTokenBundle\Service\RefreshToken;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthenticationController.
 */
class AuthenticationController extends AbstractFOSRestController
{
    /**
     * @ApiDoc\Operation(
     *     tags={"Authentication"},
     *     summary="Login check",
     *     @SWG\Parameter(
     *          name="User credentials",
     *          in="body",
     *          type="json",
     *          schema = @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="username", type="string"),
     *              @SWG\Property(property="password", type="string")
     *          )
     *     ),
     *     @SWG\Response(
     *          response="200",
     *          description="OK",
     *          schema=@SWG\Schema(
     *              @SWG\Property(property="token", type="string",),
     *              @SWG\Property(property="refresh_token", type="string",)
     *          )
     *     ),
     *     @SWG\Response(
     *          response="401",
     *          description="Unauthorized",
     *          schema=@SWG\Schema(
     *              @SWG\Property(property="code", type="integer",),
     *              @SWG\Property(property="message", type="string",)
     *          )
     *     )
     * )
     *
     * @Rest\Post("/login_check")
     * @Rest\View
     */
    public function loginCheckAction()
    {
    }

    /**
     * @ApiDoc\Operation(
     *     tags={"Authentication"},
     *     summary="Refresh token",
     *     @SWG\Parameter(
     *         name="Refresh token",
     *         in="body",
     *         type="json",
     *         schema= @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="refresh_token", type="string")
     *         )
     *     ),
     *     @SWG\Response(
     *          response="200",
     *          description="OK",
     *          schema=@SWG\Schema(
     *              @SWG\Property(property="token", type="string",),
     *              @SWG\Property(property="refresh_token", type="string",)
     *          )
     *     ),
     *     @SWG\Response(
     *          response="401",
     *          description="Unauthorized",
     *          schema=@SWG\Schema(
     *              @SWG\Property(property="code", type="integer",),
     *              @SWG\Property(property="message", type="string",)
     *          )
     *     )
     * )
     *
     * @Rest\Post("/token/refresh")
     * @Rest\View
     *
     * @param RefreshToken $refreshToken
     * @param Request      $request
     *
     * @return mixed
     */
    public function refreshTokenAction(RefreshToken $refreshToken, Request $request)
    {
        return $refreshToken->refresh($request);
    }

    /**
     * @ApiDoc\Operation(
     *     tags={"Authentication"},
     *     summary="Register",
     *     @SWG\Parameter(
     *          name="User data",
     *          in="body",
     *          description="Data for creating a user",
     *          type="json",
     *          schema = @SWG\Schema(
     *              type="object",
     *              ref= @ApiDoc\Model(type=UserDto::class)
     *          )
     *     ),
     *     @SWG\Response(response="201", description="Created"),
     *     @SWG\Response(response="400", description="Bad Request"),
     *     @SWG\Response(response="401", description="Unauthorized")
     * )
     *
     * @Rest\Post("/register")
     * @Rest\View
     *
     * @param UserDto     $userDto
     * @param UserManager $userManager
     *
     * @return User
     */
    public function registerAction(UserDto $userDto, UserManager $userManager): User
    {
        return $userManager->register($userDto);
    }
}
