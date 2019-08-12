<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

// use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal, systemException};
use model\appRegistration\appRegistrationProxy;

echo "Hello World";
