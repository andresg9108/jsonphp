<?php

namespace model\sendEmail;

use lib\MVC\query;

class querySendEmail extends query {

const INSERT = "INSERT INTO `send_email`(`email`, `code`, `subject`, `message`, `status`, `id_email_settings`) VALUES ('<1?>', '<2?>', '<3?>', '<4?>', <5?>, <6?>)";

const UPDATE = "UPDATE `send_email` 
				SET `email`='<2?>', 
				`code`='<3?>', 
				`subject`='<4?>', 
				`message`='<5?>', 
				`status`=<6?>, 
				`id_email_settings`=<7?> 
				WHERE `id`=<1?>";

const LOAD = "SELECT `id`, `registration_date`, 
				`email`, `code`, `subject`, 
				`message`, `status`, 
				`id_email_settings` 
				FROM `send_email` 
				WHERE `id`=<1?>;";
const DELETE = "DELETE FROM `send_email` WHERE `id`=<1?>;";

}
