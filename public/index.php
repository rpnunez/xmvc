<?php

use XMVC\Kernel;

// Define the absolute path to the project root
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$kernel = new Kernel();
$kernel->handle();