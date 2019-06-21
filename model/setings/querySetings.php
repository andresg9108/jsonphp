<?php

namespace model\setings;

use lib\MVC\query;

class querySetings extends query{

const GET_SETINGS_BY_SETINGS_TYPE = "SELECT `id`, `registration_date`, 
									`name`, `description`, 
									`value`, `id_settings_type` 
									FROM `setings` 
									WHERE `id_settings_type` = <1?>;";

}
