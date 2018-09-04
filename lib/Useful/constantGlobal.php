<?php

namespace lib\Useful;

use lib\MVC\constant;

class constantGlobal extends constant{

    const FAIL_CONNECTION_FAILURE_DB = "Failure to connect to the database.";
    const ERROR_IN_THE_QUERY = "Error in the query.";
	const CONTACT_SUPPORT = "We are having problems, contact technical support.";
    const CONTROLLED_EXCEPTION = "Controlled exception.";
    const SUCCESSFUL_REQUEST = "Successful application.";
    const ERROR_404 = "Error 404";
    const ERROR_SESSION = "The session could not be established.";
    const FAIL_CAPTCHA = "You must complete the Captcha for security reasons.";
    const VAL_EMPTY_PASSWORD = "You must send a password.";
    const VAL_VAL_PASSWORD = "The password must be sent with at least 5 characters.";

	// Spanish
    const SPAN_FAIL_CONNECTION_FAILURE_DB = "No se pudo conectar a la base de datos.";
    const SPAN_ERROR_IN_THE_QUERY = "Error en la consulta.";
	const SPAN_CONTACT_SUPPORT = "Estamos teniendo problemas, contacta con soporte técnico.";
    const SPAN_CONTROLLED_EXCEPTION = "Excepción contralada.";
    const SPAN_SUCCESSFUL_REQUEST = "Solicitud exitosa.";
    const SPAN_ERROR_404 = "Error 404";
    const SPAN_ERROR_SESSION = "No se pudo establecer la sesión.";
    const SPAN_FAIL_CAPTCHA = "Debes completar el Captcha por motivos de seguridad.";
    const SPAN_VAL_EMPTY_PASSWORD = "Debes enviar una contraseña.";
    const SPAN_VAL_VAL_PASSWORD = "La contraseña se debe enviar con al menos 5 caracteres.";

}
