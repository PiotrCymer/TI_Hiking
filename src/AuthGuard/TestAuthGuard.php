<?php


namespace App\AuthGuard;


use Doctrine\ORM\EntityManager;

class TestAuthGuard implements AuthGuard
{

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;

    }

    public function run() : bool
    {
        if ($this->check()) {
            return true;
        }

        return false;
    }

    private function check() : bool
    {
        return true;
        $authTokenAr = getallheaders();

        if (!isset($authTokenAr['Authorization'])) {
            return false;
        }
        $authToken = substr($authTokenAr['Authorization'], 7);
        if ($authToken == 'asshsfuodf7a92341213#sadq3xz') {
            return true;
        }

        return false;
    }
}
