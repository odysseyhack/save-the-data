<?php

namespace App\Service;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticatorService {

    /**
     * @var PasswordEncoder
     */
    private $passwordEncoder = null;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->passwordEncoder = $userPasswordEncoder;
    }


    /**
     * Checks if password equals saved hash
     * @param $credentials
     * @param UserInterface $user
     * @return bool|void
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }


    /**
     * Gets credentials from request
     * @param Request $request
     * @return array
     */
    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
        ];

        return $credentials;
    }


    /**
     * Gets necessary info from registration form
     * @param Request $request
     * @return User|null
     */
    public function getUserFromRegistration(Request $request)
    {
        $registration = $this->getRegistration($request);

        if (!$this->isValidRegistration($registration)) return null;

        return $this->createUserEntity($registration);
    }


    /**
     * Gets all fields from registration
     * @param Request $request
     * @return array
     */
    private function getRegistration(Request $request) : array
    {
        $registration = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'roles' => $request->request->get('roles')
        ];

        return $registration;
    }


    /**
     * Creates users entity from registration data
     * @param array $registration
     * @return User
     */
    private function createUserEntity(array $registration) : User
    {
        $user = new User();
        $encodedPassword = $this->passwordEncoder->encodePassword($user, $registration['password']);

        $user->setEmail($registration['email']);
        $user->setPassword($encodedPassword);
        $user->setRoles($this->getRoles($registration['roles']));

        return $user;
    }


    /**
     * Gets roles from registration and ports it to array
     * @param $roles
     * @return array
     */
    private function getRoles($roles) : array
    {
        if (is_string($roles) && stripos($roles, 'ROLE_ADMIN') > -1) {
            return ['ROLE_API', 'ROLE_ADMIN'];
        }

        return ['ROLE_API'];
    }


    /**
     * Checks if registration has valid inputx
     * @param array $registration
     * @return bool
     */
    private function isValidRegistration(array $registration)
    {
        if (!filter_var($registration['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (!is_string($registration['password']) || strlen($registration['password']) < 8) {
            return false;
        }

        return true;
    }

}