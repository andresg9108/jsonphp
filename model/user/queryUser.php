<?php

namespace model\user;

use lib\MVC\query;

class queryUser extends query {

const INSERT = "INSERT INTO `user`(`user`, `password`, `status`, `id_person`, `id_profile`) VALUES ('<1?>', '<2?>', <3?>, <4?>, <5?>)";
const LOAD = "SELECT id, registration_date, 
				user, password, 
				status, id_person, 
				id_profile 
				FROM `user` 
				WHERE id=<1?>;";
const LOAD_BY_USER = "SELECT id, registration_date, user,
						password, status, 
						id_person, id_profile 
						FROM `user` 
						WHERE `user`='<1?>'";
const UPDATE = "UPDATE `user` 
				SET user='<2?>',
				password='<3?>', 
				status=<4?>,  
				id_person=<5?>, 
				id_profile=<6?>
				WHERE id=<1?>;";

const SELECT_BY_ID_PERSON = "SELECT `id`, `registration_date`, 
									`user`, `password`, 
									`status`, `id_person`, 
									`id_profile` 
									FROM `user` 
									WHERE `id_person`=<1?>;";

}
