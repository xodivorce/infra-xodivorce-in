<?php
require dirname(__DIR__) . '/core/vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
?>