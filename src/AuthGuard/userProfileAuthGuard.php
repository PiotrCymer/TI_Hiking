<?php


namespace App\AuthGuard;


use Core\AuthGuard\AuthGuard;
use Core\AuthGuard\AuthGuardInterface;
use Doctrine\ORM\EntityManager;

class userProfileAuthGuard extends AuthGuard implements AuthGuardInterface
{
    public string $noValidTemplate = "pleaseLogin.html";

    public function __construct(EntityManager $entityManager, $matchedRoute)
    {
        $this->em = $entityManager;
        $this->matchedRoute = $matchedRoute;

    }

    protected function check(): bool
    {
        if (isset($_SESSION['user'])) {
            return true;
        }

        return false;
    }
}
