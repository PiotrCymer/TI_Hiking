<?php

namespace App\Controller;

use App\Entity\Users;
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
    public function signIn(): Response
    {

        if (!empty($_POST['action']) && $_POST['action'] == 'signin') {
            $userCheck = $this->em->getRepository("App\Entity\Users")->findOneBy(['email' => $_POST['login'], 'password' => md5($_POST['password'])]);
            sleep(1);
            if ($userCheck) {
                $_SESSION['user'] = [
                    'id' => $userCheck->getUserId(),
                    'email' => $userCheck->getEmail(),
                    'name' => $userCheck->getName(),
                    'surname' => $userCheck->getSurname()
                ];

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

    /**
     * @Route('rejestracja')
     */
    public function register(): Response
    {
        if (isset($_POST['action']) && $_POST['action'] == 'register') {
            sleep(1);
            $required = ['email', 'name', 'surname', 'password'];
            $checkEmail = $this->em->getRepository("App\Entity\Users")->findOneBy(['email' => $_POST['email']]);
            if($checkEmail) {
                return new ResponseJson(401,
                    [
                        "status" => false,
                        "message" => "Podany adres e-mail już istnieje w naszej bazie"
                    ]);
            }

            if($this->checkIfRequiredDataExist($required)) {
                $newUser = new Users();
                $newUser->setName($_POST['name']);
                $newUser->setSurname($_POST['surname']);
                $newUser->setEmail($_POST['email']);
                $newUser->setPassword(md5($_POST['password']));

                $this->em->persist($newUser);
                $this->em->flush();

                return new ResponseJson(200,
                    [
                        "status" => true,
                        "message" => "Zarejestrowano pomyślnie"
                    ]);
            }

            return new ResponseJson(400,
                [
                    "status" => false,
                    "message" => "Wystąpił błąd. Prosimy spróbować ponownie"
                ]);
        } else {
            $template = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory . "register.php";

            $view = $this->renderView($template, ['stylesheets' => $this->getStylesheets('register'), 'scripts' => $this->getJsScripts('register')]);

            return new ResponseHtml(201, ["view" => $view]);
        }
    }

    /**
     * @Route('logout')
     */
    public function logout(): Response
    {
        unset($_SESSION['user']);

        return new ResponseJson(200,
            [
                "status" => true,
                "message" => "Wylogowano pomyślnie"
            ]);
    }

    protected function getStylesheets($page): array
    {
        switch ($page) {
            case 'signin':
                $stylesheets = [
                    './assets/css/signin.css',
                    './assets/css/spin.css'
                ];
                break;
            case 'register':
                $stylesheets = [
                    './assets/css/register.css',
                    './assets/css/spin.css'
                ];
                break;
            default:
                $stylesheets = [];
                break;
        }

        return $stylesheets;
    }

    protected function getJsScripts($page): array
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
            case 'register':
                $scripts = [
                    'common' => [
                    ],
                    'module' => [
                        './assets/js/register.js'
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
