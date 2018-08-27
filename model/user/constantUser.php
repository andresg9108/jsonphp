<?php

namespace model\user;

use lib\MVC\constant;

class constantUser extends constant{

	const VAL_EMPTY_EMAIL = "Debes enviar un email.";
	const VAL_EMPTY_USUARIO = "Debes enviar un usuario.";
	const VAL_EMPTY_PASSWORD = "Debes enviar una contraseña.";
	const VAL_VAL_EMAIL = "Debes enviar un email valido.";
	const VAL_VAL_USERNAME = "Debes enviar un usuario valido e incluir al menos 5 caracteres. Caracteres permitidos: a, b, c... 0, 1, 2, 3... guion (-), guion bajo (_) y punto (.). No incluyas acentos del español (Ej: á), la letra ñ, ni espacios.";
	const VAL_VAL_PASSWORD = "La contraseña se debe enviar con al menos 5 caracteres.";
	const VAL_EXISTING_EMAIL = "Ya se registró alguien con este email ('<1?>'). Si este es tu email, ve a la sección recuperar contraseña.";
	const VAL_EXISTING_USERNAME = "Debes enviar un usuario diferente, ya se a registrado alguien con: <1?>";

	// Spanish
	const SPAN_VAL_EMPTY_EMAIL = "Debes enviar un email.";
	const SPAN_VAL_EMPTY_USUARIO = "Debes enviar un usuario.";
	const SPAN_VAL_EMPTY_PASSWORD = "Debes enviar una contraseña.";
	const SPAN_VAL_VAL_EMAIL = "Debes enviar un email valido.";
	const SPAN_VAL_VAL_USERNAME = "Debes enviar un usuario valido e incluir al menos 5 caracteres. Caracteres permitidos: a, b, c... 0, 1, 2, 3... guion (-), guion bajo (_) y punto (.). No incluyas acentos del español (Ej: á), la letra ñ, ni espacios.";
	const SPAN_VAL_VAL_PASSWORD = "La contraseña se debe enviar con al menos 5 caracteres.";
	const SPAN_VAL_EXISTING_EMAIL = "Ya se registró alguien con este email ('<1?>'). Si este es tu email, ve a la sección recuperar contraseña.";
	const SPAN_VAL_EXISTING_USERNAME = "Debes enviar un usuario diferente, ya se a registrado alguien con: <1?>";

}
