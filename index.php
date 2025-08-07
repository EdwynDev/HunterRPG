<?php
session_start();
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/core/Router.php';
require_once __DIR__ . '/app/config/config.php';

$router = new Router();
$router->dispatch();