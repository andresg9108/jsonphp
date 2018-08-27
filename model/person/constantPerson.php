<?php

namespace model\person;

use lib\MVC\constant;

class constantPerson extends constant{

	const SUCCESSFUL_REGISTRATION = "The registration was a success. Check your email to validate your information.";
	const VAL_EMPTY_NAME = "You must send a name.";
	const VAL_EMPTY_LAST_NAME = "You must send a surname.";
	const VAL_VAL_NAME = "You must send a valid name.";
	const VAL_VAL_LAST_NAME = "You must send a valid surname.";

	// Spanish
	const SPAN_SUCCESSFUL_REGISTRATION = "El registro fue todo un éxito. Revisa tu correo electronico para validar tu información.";
	const SPAN_VAL_EMPTY_NAME = "Debes enviar un nombre";
	const SPAN_VAL_EMPTY_LAST_NAME = "Debes enviar un apellido.";
	const SPAN_VAL_VAL_NAME = "Debes enviar un nombre válido.";
	const SPAN_VAL_VAL_LAST_NAME = "Debes enviar un apellido válido.";

}
