<?php

namespace model\person;

use lib\MVC\constant;

class constantPerson extends constant{

	const VAL_EMPTY_LAST_NAME = "You must send a surname.";
	const VAL_VAL_NAME = "You must send a valid name.";
	const VAL_VAL_LAST_NAME = "You must send a valid surname.";
	const EMAIL_CHECKIN_URL = "validateUser/?id=<1?>&code=<2?>";
	const EMAIL_CHECKIN_SUBJECT = "Thank you for registering.";
	
	const SPAN_VAL_EMPTY_NAME = "Debes enviar un nombre";
	const SPAN_VAL_EMPTY_LAST_NAME = "Debes enviar un apellido.";
	const SPAN_VAL_VAL_NAME = "Debes enviar un nombre válido.";
	const SPAN_VAL_VAL_LAST_NAME = "Debes enviar un apellido válido.";
    const SPAN_EMAIL_CHECKIN_SUBJECT = "Gracias por registrarse.";

}
