<?php

namespace Core\AuthGuard;

use Doctrine\ORM\EntityManager;

abstract class AuthGuard
{

    protected EntityManager $em;
    protected array $matchedRoute;

    public function run(): bool
    {
        if ($this->check()) {
            return true;
        }

        return false;
    }

}
