<?php

namespace App\Controller;

use App\DTO\UserDto;
use App\Entity\User;
use App\Service\UserManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Gesdinet\JWTRefreshTokenBundle\Service\RefreshToken;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use OpenApi\Annotations as OA;
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
     *     @OA\RequestBody(
     *          description="User credentials",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="username", type="string"),
     *              @OA\Property(property="password", type="string")
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string",),
     *              @OA\Property(property="refresh_token", type="string",)
     *          )
     *     ),
     *     @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="code", type="integer",),
     *              @OA\Property(property="message", type="string",)
     *          )
     *     )
     * )
     *
     * @Rest\Post("/api/login")
     * @Rest\View
     */
    public function loginCheckAction()
    {
    }

    /**
     * @ApiDoc\Operation(
     *     tags={"Authentication"},
     *     summary="Refresh token",
     *     @OA\RequestBody(
     *         description="Refresh token",
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="refresh_token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string",),
     *              @OA\Property(property="refresh_token", type="string",)
     *          )
     *     ),
     *     @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="code", type="integer",),
     *              @OA\Property(property="message", type="string",)
     *          )
     *     )
     * )
     *
     * @Rest\Post("/api/token/refresh")
     * @Rest\View
     *
     * @param RefreshToken $refreshToken
     * @param Request $request
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
     *     @OA\RequestBody(
     *          required=true,
     *          description="Data for creating a user",
     *          @OA\JsonContent(
     *              type="object",
     *              ref= @ApiDoc\Model(type=UserDto::class)
     *          )
     *     ),
     *     @OA\Response(response="201", description="Created"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     *
     * @Rest\Post("/api/register")
     * @Rest\View
     *
     * @param UserDto $userDto
     * @param UserManager $userManager
     *
     * @return User
     */
    public function registerAction(UserDto $userDto, UserManager $userManager): User
    {
        return $userManager->register($userDto);
    }
}
