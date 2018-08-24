<?php

namespace lib\Util;

use lib\MVC\constant;

class constantGlobal extends constant{

	const CONTACT_SUPPORT = "Estamos teniendo problemas, contacta con soporte técnico.";
    const CONTROLLED_EXCEPTION = "Excepción contralada.";
    const ERROR_404 = "Error 404";
    const ERROR_SESSION = "Session error";

    // EMAIL
    const EMAIL_CHECKIN_URL = "http://localhost/jsonphp/testHTML/validateUser/?id=<1?>&code=<2?>";

    const EMAIL_CHECKIN_SUBJECT = "Gracias por registrarse.";
    
    const EMAIL_CHECKIN_MESSAGE = "<br /><br />
    								<a href='<1?>' 
								    style='padding: 10px 20px; 
								    text-decoration: none; 
								    background-color: black; 
								    color: white;' 
								    target='_blank'>
								    Validar correo electr&oacute;nico
								    </a>";

	const EMAIL_RECOVERPASSWORD_URL = "http://localhost/jsonphp/testHTML/recoverPassword/changePassword/?id=<1?>&code=<2?>";

	const EMAIL_RECOVERPASSWORD_SUBJECT = "Recuperar contrase&ntilde;a";

	const EMAIL_RECOVERPASSWORD_MESSAGE = "<br /><br />
		    								<a href='<1?>' 
										    style='padding: 10px 20px; 
										    text-decoration: none; 
										    background-color: black; 
										    color: white;' 
										    target='_blank'>
										    Recuperar contrase&ntilde;a
										    </a>";



}
