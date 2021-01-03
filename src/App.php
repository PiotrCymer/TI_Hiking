<?php

namespace App;

use Core\Response\ResponseJson;
use Core\Router\Router;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


class App
{
    //TODO add ResponseJSON

    private Router $router;

    private EntityManager $entityManager;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function go()
    {
        if ($this->router->run()) {
            $matchedRoute = $this->router->getMatchedRoute();
            $this->initDoctrine();

            if ($matchedRoute['authguard'] != "") {
                $authGuardClassName = "App\AuthGuard\\" . $matchedRoute['authguard'];
                $authGuard = new $authGuardClassName($this->entityManager);

                if (!$authGuard->run()) {
                    $response = new ResponseJson(401, ['status' => false, 'message' => 'Nie masz uprawnien']);

                    return $response;
                }
            }

            $ref = new \ReflectionMethod($matchedRoute['controller'], $matchedRoute['method']);

            $obj = new $matchedRoute['controller']($this->entityManager, $matchedRoute['filters']);

            $ref->invokeArgs($obj, $matchedRoute['params']);
//            $controllerObject = new $matchedRoute['controller']($this->entityManager, $matchedRoute['filters']);
//            call_user_func_array([$controllerObject, $matchedRoute['method']], $matchedRoute['params']);
        } else {
            echo "Brak";
//            $response = new ResponseJson(404, ['status' => false, 'message' => 'Podany enpoint nie istnieje']);
//
//            return $response;
        }

    }

    private function initDoctrine()
    {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;

        $dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => 'pokemon123',
            'dbname' => 'itcrowd',
        );

        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src/Entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
        $this->entityManager = EntityManager::create($dbParams, $config);
    }

    private function pre($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}
