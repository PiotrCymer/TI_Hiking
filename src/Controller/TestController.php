<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\Response\Response;
use Core\Response\ResponseHtml;
use Doctrine\ORM\EntityManager;

/**
 * @Controller('test')
 */
final class TestController extends Controller
{


    public function __construct(EntityManager $entityManager, array $filters)
    {
        $this->mainTemplate = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory. "main.php";
        $this->em = $entityManager;
        $this->filters = $filters;
    }

    /**
     * @Route('test')
     */
    public function test(): Response
    {
        $template = $_SERVER['DOCUMENT_ROOT'] . $this->templatesDirectory. "test.php";

        return new ResponseHtml(201, ["template" => $this->mainTemplate, "content" => $this->renderView($template)]);
    }
}
