<?php

namespace model\emailUser;

use lib\MVC\constant;

class constantEmailUser extends constant{
	
	const VAL_EXISTING_EMAIL = "Someone has already registered with this email ('<1?>'). If this is your email, go to the recover password section.";
	const VAL_EMPTY_EMAIL = "You must send an email.";
	const VAL_VAL_EMAIL = "You must send a valid email.";

	// Spanish
	const SPAN_VAL_EXISTING_EMAIL = "Ya se registró alguien con este email ('<1?>'). Si este es tu email, ve a la sección recuperar contraseña.";
	const SPAN_VAL_EMPTY_EMAIL = "Debes enviar un email.";
	const SPAN_VAL_VAL_EMAIL = "Debes enviar un email valido.";

}
