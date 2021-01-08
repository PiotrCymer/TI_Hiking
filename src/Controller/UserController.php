<?php

namespace App\Controller;

use App\Entity\Hiking;
use App\Entity\Users;
use Core\Controller\Controller;
use Core\Response\Response;
use Core\Response\ResponseHtml;
use Core\Response\ResponseJson;
use Doctrine\ORM\EntityManager;

/**
 * @Controller('profil-uzytkownika')
 */
final class UserController extends Controller
{
    private string $hikingImagesPath = "/assets/images/trips";
    private string $hikingVideosPath = "/assets/videos/trips";

    public function __construct(EntityManager $entityManager, array $filters)
    {
        $this->mainTemplate = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory . "userProfileMain.php";
        $this->em = $entityManager;
        $this->filters = $filters;
    }

    /**
     * @Route('/')
     * @AuthGuard('userProfileAuthGuard')
     */
    public function hikingList()
    {

        $template = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory . "hikingList.php";

        $view = $this->renderView($template, ['stylesheets' => $this->getStylesheets('user'), 'scripts' => $this->getJsScripts('signin')]);

        return new ResponseHtml(201, ["view" => $view]);
    }

    /**
     * @Route('nowa-wedrowka')
     * @AuthGuard('userProfileAuthGuard')
     */
    public function addHiking()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'add') {
            $requiredVales = ['hikingName', 'hikingStartDate', 'hikingEndDate', 'hikingStartPlace', 'hikingEndPlace', 'hikingLength'];
            if ($this->checkIfRequiredDataExist($requiredVales)) {
                $this->pre($_FILES);


                $newHiking = new Hiking();

                $newHiking->setName($_POST['hikingName']);
                $newHiking->setStartDate(new \DateTime($_POST['hikingStartDate']));
                $newHiking->setEndDate(new \DateTime($_POST['hikingEndDate']));
                $newHiking->setStartingPoint($_POST['hikingStartPlace']);
                $newHiking->setDestination($_POST['hikingEndPlace']);
                $newHiking->setLength($_POST['hikingLength']);

                /**
                 * @var Users $user
                 */
                $user = $this->em->getRepository("App\Entity\Users")->findOneBy(["userId" => $_SESSION['user']['id']]);
                $newHiking->setUserId($user);
//
                if (count($_FILES['hikingImages']['name']) > 0 && $_FILES['hikingImages']['name'][0] != "") {
                    $images = [];

                    foreach ($_FILES['hikingImages']['name'] as $k => $v) {
                        $newName = md5($v . uniqid()) . $this->getExtension($_FILES['hikingImages']['type'][$k]);
                        $pathToDatabase = $this->hikingImagesPath . "/" . $newName;
                        $pathToUpload = $_SERVER['DOCUMENT_ROOT'] . $pathToDatabase;
                        move_uploaded_file($_FILES['hikingImages']['tmp_name'][$k], $pathToUpload);
                        array_push($images, $pathToDatabase);
                    }
                    $newHiking->setImages(serialize($images));
                } else {
                    $newHiking->setImages("a:0:{}");
                }

                if ($_FILES['hikingVideo']['name'] != "") {


                    $newName = md5($_FILES['hikingVideo']['name'][0] . uniqid()) . $this->getExtension($_FILES['hikingVideo']['type']);
                    $pathToDatabase = $this->hikingVideosPath . "/" . $newName;
                    $pathToUpload = $_SERVER['DOCUMENT_ROOT'] . $pathToDatabase;
                    move_uploaded_file($_FILES['hikingVideo']['tmp_name'], $pathToUpload);
                    array_push($images, $pathToDatabase);

                    $newHiking->setVideo(serialize($pathToDatabase));
                } else {
                    $newHiking->setVideo("");
                }

                $this->em->persist($newHiking);
                $this->em->flush();
                $_SESSION['messages']['hikingAdded'] = true;

            } else {
                return new ResponseJson(400, ['status' => false, "message" => "Wszystkie informacje na temat wędrówki muszą zostać wypełnione! Możesz jedynie zrezygnować z dodawania zdjęć i filmu."]);
            }

        } else {
            $template = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory . "addHiking.php";

            $view = $this->renderView($template, ['stylesheets' => $this->getStylesheets('addHiking'), 'scripts' => $this->getJsScripts('addHiking')]);

            return new ResponseHtml(201, ["view" => $view]);
        }


    }

    private function getExtension(string $type): string
    {
        switch ($type) {
            case 'image/png':
                $extension = ".png";
                break;

            case 'image/jpeg':
                $extension = ".jpg";
                break;

            case 'application/mp4':
                $extension = ".mp4";
                break;

            case 'video/quicktime':
                $extension = ".mov";
                break;


        }

        return $extension;
    }

    protected function getStylesheets($page): array
    {
        switch ($page) {
            case 'user':
                $stylesheets = [
                    '/assets/css/dropzone.css'
                ];
                break;
            case 'addHiking':
                $stylesheets = [
                    'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
                    '/assets/css/addHiking.css'
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
            case 'user':
                $scripts = [
                    'common' => [
                        '/assets/js/addHiking.js'
                    ],
                    'module' => [
                        '/assets/js/spin.js'
                    ]
                ];
                break;
            case 'addHiking':
                $scripts = [
                    'common' => [
                        '/assets/js/addHiking.js',
                        'https://cdn.jsdelivr.net/npm/flatpickr'
                    ],
                    'module' => []
                ];
                break;
            default:
                $scripts = [];
                break;
        }

        return $scripts;
    }
}
