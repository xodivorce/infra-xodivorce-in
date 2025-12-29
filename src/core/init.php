<?php
require dirname(__DIR__) . '/core/vendor/autoload.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
?>