<?php
if ($_SERVER['REQUEST_URI'] === 'localhots') {
  error_reporting(E_ALL);
}

require_once __DIR__ . '/../app/autoload.php';

$router = new Router();
$router->run();