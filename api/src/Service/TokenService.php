<?php

namespace App\Service;

use App\Entity\User;
use Predis;

class TokenService {

    private $client = null;

    public function __construct()
    {
        $this->client = new Predis\Client([
            "schema" => "tcp",
            "host" => getenv("REDIS_HOST"),
            "port" => getenv("REDIS_PORT"),
        ]);
    }


    /**
     * Generates token and adds key user pars to redis
     * @param User $user
     * @return string
     */
    public function generateToken(User $user) : string
    {
        $token = $user->getId() . bin2hex(openssl_random_pseudo_bytes(15));

        $this->client->hset($token, 'roles', implode(',', $user->getRoles()));
        $this->client->hset($token, 'email', $user->getEmail());
        $this->client->hset($token, 'id', $user->getId());
        $this->client->expire($token, 43200);

        return $token;
    }


    /**
     * Checks if token is in redis store,
     * returns all necessary items in a user object
     * @param string $token
     * @return User|null
     */
    public function tokenIsValid(string $token)
    {
        $userData = $this->client->hgetall($token);

        if (!is_null($userData) && is_array($userData)) {
            $user = new User();
            $user->setRoles(explode(',', $userData['roles']));
            $user->setEmail($userData['email']);
            $user->setId((int) $userData['id']);

            return $user;
        }

        return null;
    }

}
