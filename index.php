<?php

include('./vendor/autoload.php');

header("X-Robots-Tag: noindex, nofollow", true);

use Core\Router\Router;
use App\App;

$url = $_SERVER['REQUEST_URI'];

$router = new Router($url);
$app = new App($router);
$app->go();
