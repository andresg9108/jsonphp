<?php

namespace lib\Useful;

use lib\MVC\constant;

class constantGlobal extends constant{

	const CONTACT_SUPPORT = "We are having problems, contact technical support.";
    const CONTROLLED_EXCEPTION = "Controlled exception.";
    const SUCCESSFUL_REQUEST = "Successful application.";
    const ERROR_404 = "Error 404";
    const ERROR_SESSION = "The session could not be established.";
	const EMAIL_RECOVERPASSWORD_SUBJECT = "Recover password";
	const EMAIL_RECOVERPASSWORD_URL = "http://localhost/jsonphp/testHTML/recoverPassword/changePassword/?id=<1?>&code=<2?>";

	// Spanish
	const SPAN_CONTACT_SUPPORT = "Estamos teniendo problemas, contacta con soporte técnico.";
    const SPAN_CONTROLLED_EXCEPTION = "Excepción contralada.";
    const SPAN_SUCCESSFUL_REQUEST = "Solicitud exitosa.";
    const SPAN_ERROR_404 = "Error 404";
    const SPAN_ERROR_SESSION = "No se pudo establecer la sesión.";
	const SPAN_EMAIL_RECOVERPASSWORD_SUBJECT = "Recuperar contraseña";

}
