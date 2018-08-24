<?php

namespace model\sendEmail;

use lib\MVC\query;

class querySendEmail extends query {

const INSERT = "INSERT INTO `send_email`(`email`, `code`, `subject`, `message`, `id_email`) VALUES ('<1?>', '<2?>', '<3?>', '<4?>', <5?>)";
const LOAD = "SELECT `id`, `registration_date`, 
				`email`, `code`, `subject`, 
				`message`, `id_email` 
				FROM `send_email` 
				WHERE `id`=<1?>;";
const DELETE = "DELETE FROM `send_email` WHERE `id`=<1?>;";

}
