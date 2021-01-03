<?php


namespace App\AuthGuard;


use Doctrine\ORM\EntityManager;

interface AuthGuard
{
    public function __construct(EntityManager $entityManager);
    public function run() : bool;
}
