<?php

namespace Core\Router;

use App\Controller\MainController;

final class Router
{

    //TODO implement router interface

    private string $url;

    private array $urlArray = [];

    private string $controllersFolderPath = "./src/Controller";

    private array $controllers = [];

    private array $matchedRoute = [];

    private array $endpointParams = [];

    public function __construct(string $url)
    {
        $this->url = $url;

        $controllersPath = glob($this->controllersFolderPath . "/*.php");

        foreach ($controllersPath as $path) {
            $exPath = explode('/', $path);
            $controllerName = explode('.', end($exPath));
            array_push($this->controllers, $controllerName[0]);
        }
    }

    public function run()
    {
        if ($this->processUrl()) {
            $matchedController = $this->matchController();

            if ($matchedController['status']) {
                foreach ($matchedController['controller']->getMethods() as $method) {
                    if ($method->isPrivate() || $method->isProtected() || $method->isConstructor()) {
                        continue;
                    }

                    $comment = $this->parseComment($method->getDocComment());

                    if ($comment['route'] == $this->urlArray['route']) {
                        if (isset($comment['authguard']) && $comment['authguard'] != "") {
                            $authGuard = $comment['authguard'];
                        } else {
                            $authGuard = "";
                        }
                        $this->matchedRoute = [
                            'controller' => $matchedController['controller']->getName(),
                            'method' => $method->name,
                            'params' => $this->endpointParams,
                            'filters' => $this->urlArray['filters'],
                            'authguard' => $authGuard
                        ];
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function getMatchedRoute()
    {
        return $this->matchedRoute;
    }

    private function matchController(): array
    {
        foreach ($this->controllers as $controller) {
            $classReflection = new \ReflectionClass('\\App\Controller\\' . $controller);
            $controllerAnnotation = $this->parseComment($classReflection->getDocComment());

            if ($controllerAnnotation['controller'] == $this->urlArray['controller']) {
                return array('status' => true, 'controller' => $classReflection);
            }
        }

        return array('status' => false);
    }

    private function parseComment(string $comment): array
    {
        $commentArray = array();
        $annotationName = "";

        $e = strtok($comment, "@");
        $i = 0;
        while ($e !== false) {

            if ($i == 0) {
                $i++;
                $e = strtok("@");
                continue;
            }

            $annotationName = substr($this->removeCommentSigns($e), 0, strpos($this->removeCommentSigns($e), '('));

            $commentArray[strtolower($annotationName)] = substr($this->removeCommentSigns($e), strpos($this->removeCommentSigns($e), '(') + 2, -4);
            $e = strtok("@");
            $i++;
        }

        return $commentArray;
    }

    private function processUrl(): bool
    {
        $parsedUrl = parse_url($this->url);

        if ($parsedUrl['path'] != '/') {
            $urlArray = [];
            $routePath = "";
            $firstPath = "";

            $singlePath = strtok($parsedUrl['path'], '/');

            $i = 0;
            while ($singlePath !== false) {
                if ($i == 0) {
                    $firstPath = $singlePath;
                } else {
                    $routePath .= "/" . $singlePath;
                }

                $singlePath = strtok("/");
                $i++;
            }
            $route = $this->parseRoute($routePath);

            if($route == "/") {
                if (in_array($firstPath, $this->getBaseControllerMethods())) {
                    $urlArray['controller'] = 'main';
                    $urlArray['route'] = $firstPath;
                } else {
                    $urlArray['controller'] = $firstPath;
                    $urlArray['route'] = '/';
                }
            } else {
                $urlArray['controller'] = $firstPath;
                $urlArray['route'] = $route;
            }

            if (isset($parsedUrl['query'])) {
                $urlArray['filters'] = $this->parseFilters($parsedUrl['query']);
            } else {
                $urlArray['filters'] = [];
            }

            $this->urlArray = $urlArray;

            return true;
        } else {
            if (empty($_SESSION['user'])) {
                $this->urlArray['controller'] = 'main';
                $this->urlArray['route'] = 'signin';
                $this->urlArray['filters'] = [];
            } else {
                //TODO redirect to user homepage
            }

            return true;

        }
    }

    private function parseFilters($filtersString): array
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return [];
        }

        $filtersExplode = explode('&', $filtersString);
        $filters = [];
        foreach ($filtersExplode as $singleFilter) {
            $filterExplode = explode('=', $singleFilter);

            if (count($filterExplode) == 1 || $filterExplode[1] == "") {
                continue;
            }
            $filters[$filterExplode[0]] = $filterExplode[1];
        }


        return $filters;
    }

    private function parseRoute(string $endpoint): string
    {
        if ($endpoint == "") {
            return "/";
        }
        $endpointParts = [];
        $tmp = strtok($endpoint, "/");
        while ($tmp !== false) {
            array_push($endpointParts, $tmp);
            $tmp = strtok("/");
        }

        $return = "";

        foreach ($endpointParts as $part) {
            if (preg_match("/^[0-9]+$/i", $part)) {
                array_push($this->endpointParams, $part);
                $return .= "/{id}";
            } else {
                $return .= "/" . $part;
            }
        }
        return substr($return, 1);
    }

    private function removeCommentSigns(string $comment): string
    {
        return strtr($comment, array('*/' => "", "*" => '', ' ' => ''));
    }

    private function getBaseControllerMethods(): array
    {
        try {
            $baseController = new \ReflectionClass(MainController::class);

            $baseControllerMethods = [];
            foreach ($baseController->getMethods() as $method) {
                if ($method->isPrivate() || $method->isProtected() || $method->isConstructor()) {
                    continue;
                }

                $comment = $this->parseComment($method->getDocComment());

                array_push($baseControllerMethods, $comment['route']);
            }

            return $baseControllerMethods;
        } catch (\Exception $e) {
            if ($e instanceof \ReflectionException) {
                return [];
            }

            die("Wystąpił nieoczekiwany błąd. Przepraszamy");
        }
    }

    private function pre($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}
