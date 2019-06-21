<?php

namespace model\sendEmail;

use lib\MVC\constant;

class constantSendEmail extends constant{
	const FAIL_EMAIL_SEND = "The email could not be sent.";
	const EMAIL_HAS_BEEN_SEND = "The e-mail has been sent.";
	const STATUS_EMAIL_SENT = "The status of this email is 'sent'.";
	
	// Spanish
	const SPAN_FAIL_EMAIL_SEND = "No se pudo enviar el correo electrónico.";
	const SPAN_EMAIL_HAS_BEEN_SEND = "El correo electrónico ha sido enviado.";
	const SPAN_STATUS_EMAIL_SENT = "El estado de este correo electrónico es 'enviado'.";
}
