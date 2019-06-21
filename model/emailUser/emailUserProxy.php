<?php

namespace model\sendEmail;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal};
use lib\MVC\proxy;
use model\{connection, systemException};
use model\emailUser\{emailUser, queryEmailUser, constantEmailUser};

class emailUserProxy extends proxy {
}
