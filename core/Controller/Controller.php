<?php

namespace Core\Controller;

use Doctrine\ORM\EntityManager;

abstract class Controller
{

    protected string $mainTemplate;

    protected string $content;

    protected string $templatesDirectory = "/templates/";

    abstract public function __construct(EntityManager $entityManager, array $filters);

    protected function renderMainTemplate($content)
    {
        if (!file_exists($this->mainTemplate)) {
            die("Wystąpił błąd");
        }

        include($this->mainTemplate);
    }

    protected function renderView($template): string
    {
        ob_start();
        include($template);

        $content = ob_get_contents();

        ob_clean();

        return $content;

    }

    protected function pre($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }


}
