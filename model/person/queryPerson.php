<?php

namespace model\person;

use lib\MVC\query;

class queryPerson extends query{

const INSERT = "INSERT INTO `person`(`name`, `last_name`) VALUES ('<1?>', '<2?>');";
const UPDATE = "UPDATE `person` 
				SET `name`='<2?>',
				`last_name`='<3?>' 
				WHERE `id`=<1?>;";

}
