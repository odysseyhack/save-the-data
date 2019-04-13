<?php

namespace App\Controller;


use App\Entity\User;
use App\Service\AuthenticatorService;
use App\Service\TokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends AbstractController {



    /**
     * Login route
     * @param Request $request
     * @param AuthenticatorService $authService
     * @param TokenService $tokenService
     * @return JsonResponse
     */
    public function login(Request $request, AuthenticatorService $authService, TokenService $tokenService)
    {
        $credentials = $authService->getCredentials($request);
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        /**
         * @var User $user
         */
        $user = $userRepo->findOneBy(['email' => $credentials['email']]);

        if (!$user) {
            return new JsonResponse(['state' => 'error', 'message' => 'User not found.'], 400);
        }

        if ($authService->checkCredentials($credentials, $user)) {
            $token = $tokenService->generateToken($user);
            return new JsonResponse(['state' => 'success', 'token' => $token]);
        };

        return new JsonResponse(['state' => 'error', 'message' => 'Credentials incorrect.'], 400);
    }


    /**
     * Registration route only for admin users
     * @param Request $request
     * @param AuthenticatorService $authService
     * @return JsonResponse
     */
    public function register(Request $request, AuthenticatorService $authService)
    {
        $this->getUser();
        $user = $authService->getUserFromRegistration($request);

        if (is_null($user)) {
            return new JsonResponse(['state' => 'error', 'message' => 'Invalid registration.'], 400);
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['state' => 'success', 'message' => 'Successfully created account.']);
    }


}