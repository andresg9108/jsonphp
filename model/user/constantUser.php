<?php

namespace model\user;

use lib\MVC\constant;

class constantUser extends constant{

	const VAL_EMPTY_EMAIL_RECOVER_PASSWORD = "You must send an email.";
	const VAL_VAL_EMAIL_RECOVER_PASSWORD = "You must send a valid email.";
	const FAIL_VALIDATE_RECOVER_PASSWORD = "This link can only be used once. Try again.";
	const FAIL_EMAIL_RECOVER_PASSWORD = "No one has been registered with this email.";
	const FAIL_VALIDATE_LOGIN = "Incorrect user or password.";
	const FAIL_VALIDATE_USER = "You must validate your email.";
	const FAIL_VALIDATE_USER_BY_EMAIL = "An error occurred when trying to validate this information, contact technical support.";
	const VAL_EMPTY_USUARIO = "You must send a user.";
	const VAL_VAL_USERNAME = "You must send a valid user and include at least 5 characters. Permitted characters: a, b, c ... 0, 1, 2, 3 ... hyphen (-), underscore (_) and period (.). Do not include accents of Spanish (Ej: á), the letter ñ, or spaces.";
	const VAL_EXISTING_USERNAME = "You must send a different user, someone has already been registered with: <1?>";
	const EMAIL_SUBJECT_RECOVER_PASSWORD = "Recover password";
	const EMAIL_RECOVER_PASSWORD_URL = "recoverPassword/change/?id=<1?>&code=<2?>";
	const ERROR_REGISTERED_USER_BY_EMAIL = "There is already a registered user with this email.";
	const ERROR_REGISTERED_USER_BY_USERNAME = "Choose another username.";

	// Spanish
	const SPAN_VAL_EMPTY_EMAIL_RECOVER_PASSWORD = "Debes enviar un email.";
	const SPAN_VAL_VAL_EMAIL_RECOVER_PASSWORD = "Debes enviar un email válido.";
	const SPAN_FAIL_VALIDATE_RECOVER_PASSWORD = "Este link solo puede ser usado una sola vez. Intentalo nuevamente.";
	const SPAN_FAIL_EMAIL_RECOVER_PASSWORD = "No se ha registrado nadie con este correo electrónico.";
	const SPAN_FAIL_VALIDATE_LOGIN = "Usuario o contraseña incorrecta.";
	const SPAN_FAIL_VALIDATE_USER = "Debes validar tu correo electrónico.";
	const SPAN_FAIL_VALIDATE_USER_BY_EMAIL = "Ha ocurrido un error al intentar validar esta información, contacta con soporte técnico.";
	const SPAN_VAL_EMPTY_USUARIO = "Debes enviar un usuario.";
	const SPAN_VAL_VAL_USERNAME = "Debes enviar un usuario valido e incluir al menos 5 caracteres. Caracteres permitidos: a, b, c... 0, 1, 2, 3... guion (-), guion bajo (_) y punto (.). No incluyas acentos del español (Ej: á), la letra ñ, ni espacios.";
	const SPAN_VAL_EXISTING_USERNAME = "Debes enviar un usuario diferente, ya se a registrado alguien con: <1?>";
	const SPAN_EMAIL_SUBJECT_RECOVER_PASSWORD = "Recuperar contraseña.";
	const SPAN_ERROR_REGISTERED_USER_BY_EMAIL = "Ya hay un usuario registrado con este correo electrónico.";
	const SPAN_ERROR_REGISTERED_USER_BY_USERNAME = "Elija otro nombre de usuario.";

}
