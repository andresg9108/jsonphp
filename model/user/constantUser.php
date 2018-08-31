<?php

namespace model\user;

use lib\MVC\constant;

class constantUser extends constant{

	const FAIL_VALIDATE_LOGIN = "Incorrect user or password.";
	const FAIL_VALIDATE_USER = "You must validate your email.";
	const FAIL_VALIDATE_USER_BY_EMAIL = "An error occurred when trying to validate this information, contact technical support.";
	const SUCCESSFUL_VALIDATE_USER_BY_EMAIL = "You have validated your email successfully.";
	const SUCCESSFUL_RECOVER_PASSWORD = "An email has been sent with the data corresponding to the recovery of the password.";
	const VAL_EMPTY_USUARIO = "You must send a user.";
	const VAL_EMPTY_PASSWORD = "You must send a password.";
	const VAL_VAL_USERNAME = "You must send a valid user and include at least 5 characters. Permitted characters: a, b, c ... 0, 1, 2, 3 ... hyphen (-), underscore (_) and period (.). Do not include accents of Spanish (Ej: á), the letter ñ, or spaces.";
	const VAL_VAL_PASSWORD = "The password must be sent with at least 5 characters.";
	const VAL_EXISTING_USERNAME = "You must send a different user, someone has already been registered with: <1?>";

	// Spanish
	const SPAN_FAIL_VALIDATE_LOGIN = "Usuario o contraseña incorrecta.";
	const SPAN_FAIL_VALIDATE_USER = "Debes validar tu correo electrónico.";
	const SPAN_FAIL_VALIDATE_USER_BY_EMAIL = "Ha ocurrido un error al intentar validar esta información, contacta con soporte técnico.";
	const SPAN_SUCCESSFUL_VALIDATE_USER_BY_EMAIL = "Has validado tu correo electrónico con éxito.";
	const SPAN_SUCCESSFUL_RECOVER_PASSWORD = "Se ha enviado un email con los datos que corresponden a la recuperación de la contraseña.";
	const SPAN_VAL_EMPTY_USUARIO = "Debes enviar un usuario.";
	const SPAN_VAL_EMPTY_PASSWORD = "Debes enviar una contraseña.";
	const SPAN_VAL_VAL_USERNAME = "Debes enviar un usuario valido e incluir al menos 5 caracteres. Caracteres permitidos: a, b, c... 0, 1, 2, 3... guion (-), guion bajo (_) y punto (.). No incluyas acentos del español (Ej: á), la letra ñ, ni espacios.";
	const SPAN_VAL_VAL_PASSWORD = "La contraseña se debe enviar con al menos 5 caracteres.";
	const SPAN_VAL_EXISTING_USERNAME = "Debes enviar un usuario diferente, ya se a registrado alguien con: <1?>";

}
