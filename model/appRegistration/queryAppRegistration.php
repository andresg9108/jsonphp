<?php

namespace model\appRegistration;

use lib\MVC\query;

class queryAppRegistration extends query{

const INSERT = "INSERT INTO `app_registration`(`registration_code`) VALUES ('<1?>')";
const LOAD = "SELECT `id`,
				`registration_date`,
				`registration_code`
				FROM `app_registration`
				WHERE `id`=<1?>;";
const DELETE = "DELETE FROM `app_registration` WHERE `id`=<1?>;";

}

?>