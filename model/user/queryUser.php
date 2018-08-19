<?php

namespace model\user;

use lib\MVC\query;

class queryUser extends query {

const INSERT = "INSERT INTO `user`(`email`, `user`, `password`, `status`, `registration_code`, `id_person`, `id_profile`) VALUES ('<1?>', '<2?>', '<3?>', <4?>, '<5?>', <6?>, <7?>)";
const LOAD = "SELECT id, registration_date,
				email, user,
				password, status,
				registration_code, id_person, id_profile 
				FROM `user` 
				WHERE id=<1?>;";
const LOADXUSER = "SELECT id, registration_date,
					email, user,
					password, status,
					registration_code, id_person, id_profile 
					FROM `user` 
					WHERE `user`='<1?>'";
const LOADXEMAIL = "SELECT id, registration_date,
					email, user,
					password, status,
					registration_code, id_person, id_profile 
					FROM `user` 
					WHERE `email`='<1?>'";
const UPDATE = "UPDATE `user` 
			SET email='<2?>', 
			user='<3?>',
			password='<4?>', 
			status=<5?>, 
			registration_code='<6?>', 
			id_person=<7?> 
			id_profile=<8?>
			WHERE id=<1?>;";

const SELECT_BY_ID_PERSON = "SELECT `id`, `registration_date`, 
							`email`, `user`, `password`, 
							`status`, `registration_code`, `id_person`, 
							`id_profile` 
							FROM `user` 
							WHERE `id_person`=<1?>;";

}

?>