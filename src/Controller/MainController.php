<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\Response\Response;
use Core\Response\ResponseHtml;
use Core\Response\ResponseJson;
use Doctrine\ORM\EntityManager;

/**
 * @Controller('main')
 */
final class MainController extends Controller
{


    public function __construct(EntityManager $entityManager, array $filters)
    {
        $this->mainTemplate = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory . "main.php";
        $this->em = $entityManager;
        $this->filters = $filters;
    }

    /**
     * @Route('signin')
     */
    public function test(): Response
    {

        if (!empty($_POST['action']) && $_POST['action'] == 'signin') {
            $userCheck = $this->em->getRepository("App\Entity\Users")->findOneBy(['email' => $_POST['login'], 'password' => md5($_POST['password'])]);
            sleep(1);
            if ($userCheck) {
                return new ResponseJson(200,
                    [
                        "status" => true,
                        "message" => "Zalogowano"
                    ]);
            }

            return new ResponseJson(401,
                [
                    "status" => false,
                    "message" => "Podane złe dane logowania"
                ]);

        } else {
            $template = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory . "login.php";

            $view = $this->renderView($template, ['stylesheets' => $this->getStylesheets('signin'), 'scripts' => $this->getJsScripts('signin')]);

            return new ResponseHtml(201, ["view" => $view]);
        }

    }

    private function getStylesheets($page): array
    {
        switch ($page) {
            case 'signin':
                $stylesheets = [
                    './assets/css/signin.css',
                    './assets/css/spin.css'
                ];
                break;
            default:
                $stylesheets = [];
                break;
        }

        return $stylesheets;
    }

    private function getJsScripts($page): array
    {
        switch ($page) {
            case 'signin':
                $scripts = [
                    'common' => [

                    ],
                    'module' => [
                        './assets/js/spin.js',
                        './assets/js/signin.js'
                    ]
                ];
                break;
            default:
                $scripts = [];
                break;
        }

        return $scripts;
    }
}
