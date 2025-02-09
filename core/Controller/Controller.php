<?php

namespace Core\Controller;

use Doctrine\ORM\EntityManager;

abstract class Controller
{

    protected string $mainTemplate;

    protected string $content;

    protected string $templatesDirectory = "/templates/";

    abstract public function __construct(EntityManager $entityManager, array $filters);

    abstract protected function getStylesheets(string $page) : array;

    abstract protected function getJsScripts(string $page) : array;

    protected function renderView($template, array $args = []): string
    {
        extract($args);

        ob_start();

        include($template);

        $content = ob_get_contents();
        ob_clean();

        ob_start();
        include($this->mainTemplate);

        $view = ob_get_contents();
        ob_clean();


        return $view;
    }

    protected function renderTemplate($template, array $args = []) : string
    {
        extract($args);

        ob_start();

        include($template);

        $content = ob_get_contents();
        ob_clean();

        return $content;
    }

    protected function checkIfRequiredDataExist($required)
    {
        $status = true;

        foreach ($required as $v) {
            if (!array_key_exists($v, $_POST)) {
                $status = false;
            } else if ($_POST[$v] == "") {
                $status = false;
            }
        }

        return $status;
    }

    protected function pre($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }


}
