<?php


namespace Core\AuthGuard;

use Doctrine\ORM\EntityManager;

interface AuthGuardInterface
{
    public function __construct(EntityManager $entityManager, $matchedRoute);
    public function run() : bool;
}
