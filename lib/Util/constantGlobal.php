<?php

namespace lib\Util;

use lib\MVC\constant;

class constantGlobal extends constant{

	const CONTACT_SUPPORT = "Estamos teniendo problemas, contacta con soporte técnico.";
    const CONTROLLED_EXCEPTION = "Excepción contralada.";
    const ERROR_404 = "Error 404";
    const ERROR_SESSION = "Session error";

    // EMAIL
    const EMAIL_CHECKIN_URL = "http://localhost/jsonphp/testHTML/validateUser/?id=100&code=ABCD";
    const EMAIL_CHECKIN_SUBJECT = "Prueba de asusnto (ANDRES)";
    const EMAIL_CHECKIN_MESSAGE = "Prueba de message (ANDRES)";

}

?>