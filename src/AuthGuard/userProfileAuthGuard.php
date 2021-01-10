<?php


namespace App\AuthGuard;


use Doctrine\ORM\EntityManager;

class userProfileAuthGuard implements AuthGuard
{
    public string $noValidTemplate = "pleaseLogin.html";

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;

    }

    public function run(): bool
    {
        if ($this->check()) {
            return true;
        }

        return false;
    }

    private function check(): bool
    {
        if (isset($_SESSION['user'])) {
            return true;
        }

        return false;
    }
}
