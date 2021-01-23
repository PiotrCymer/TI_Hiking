<?php


namespace App\AuthGuard;


use App\Entity\Hiking;
use Core\AuthGuard\AuthGuard;
use Core\AuthGuard\AuthGuardInterface;
use Doctrine\ORM\EntityManager;

class userHikingAuthGuard extends AuthGuard implements AuthGuardInterface
{
    public string $noValidTemplate = "sbElseHiking.html";

    public function __construct(EntityManager $entityManager, $matchedRoute)
    {
        $this->em = $entityManager;
        $this->matchedRoute = $matchedRoute;
    }

    protected function check(): bool
    {
        if (!isset($_SESSION['user'])) {
            $this->noValidTemplate = "pleaseLogin.html";
            return false;
        }

        /**
         * @var Hiking $hiking
         */
        $hiking = $this->em->getRepository("App\Entity\Hiking")->findOneBy(["id" => $this->matchedRoute['params'][0]]);

        if (!$hiking) {
            return true;
        }

        if ($_SESSION['user']['id'] != $hiking->getUserId()->getUserId()) {
            $this->noValidTemplate = "sbElseHiking.html";
            return false;
        }

        return true;
    }
}
