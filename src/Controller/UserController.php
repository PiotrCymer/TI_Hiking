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

    public array $userHiking;

    public function __construct(EntityManager $entityManager, array $filters)
    {
        $this->mainTemplate = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory . "userProfileMain.php";
        $this->em = $entityManager;
        $this->filters = $filters;

        $this->userHiking = $this->em->getRepository("App\Entity\Hiking")->findBy(["userId" => $_SESSION['user']['id']]);

    }

    /**
     * @Route('/')
     * @AuthGuard('userProfileAuthGuard')
     */
    public function hikingList()
    {

        if (isset($_POST['sortOrder'])) {
            switch ($_POST['sortOrder']) {
                case 'fromNewest':
                    $sortOrder = "DESC";
                    break;
                case 'fromOldest':
                default:
                    $sortOrder = 'ASC';
                    break;
            }
        } else {
            $sortOrder = "ASC";
        }

        /**
         * @var Hiking $hikings
         */
        $hikings = $this->em->getRepository("App\Entity\Hiking")->findBy(["userId" => $_SESSION['user']['id']], ['startDate' => $sortOrder]);


        if (isset($_POST['action']) && $_POST['action'] == 'sort') {
            $template = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory . "hikingListData.php";

            $view = $this->renderTemplate($template, ['stylesheets' => $this->getStylesheets('user'), 'scripts' => $this->getJsScripts('signin'), 'hikings' => $hikings]);

            return new ResponseJson(201, ['body' => $view]);
        } else {
            $template = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory . "hikingList.php";

            $view = $this->renderView($template, ['stylesheets' => $this->getStylesheets('user'), 'scripts' => $this->getJsScripts('signin'), 'hikings' => $hikings]);

            return new ResponseHtml(201, ["view" => $view]);
        }

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

                    $newHiking->setVideo($pathToDatabase);
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

    /**
     * @Route('wedrowki/{id}')
     * @AuthGuard('userHikingAuthGuard')
     */
    public function singleHiking($id)
    {
        $template = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory . "singleHiking.php";

        $hiking = $this->em->getRepository("App\Entity\Hiking")->findOneBy(["id" => $id]);

        if (!$hiking) {
            $view = $this->renderView($template, ['stylesheets' => $this->getStylesheets(''), 'scripts' => $this->getJsScripts('s'), 'noHiking' => true]);

            $response = new ResponseHtml(200, ["view" => $view]);


            return $response;
        }

        $hikingImages = unserialize($hiking->getImages());

        $view = $this->renderView($template, ['stylesheets' => $this->getStylesheets(''), 'scripts' => $this->getJsScripts('s'), 'noHiking' => false, 'hiking' => $hiking, 'hikingImages' => $hikingImages]);

        return new ResponseHtml(201, ["view" => $view]);
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
            case 'video/mp4':
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
                    '/assets/css/addHiking.css',
                    './assets/css/spin.css',
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
                    ],
                    'module' => [
                        '/assets/js/spin.js',
                        '/assets/js/addHiking.js'
                    ]
                ];
                break;
            case 'addHiking':
                $scripts = [
                    'common' => [
                        'https://cdn.jsdelivr.net/npm/flatpickr'
                    ],
                    'module' => [
                        '/assets/js/addHiking.js'
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
