<?php

namespace model\emailUser;

use lib\MVC\query;

class queryEmailUser extends query {

const LOAD = "SELECT `id`, `email`, 
				`registration_code`, `main`, 
				`status`, `id_user` 
				FROM `email_user` 
				WHERE `id`=<1?>;";
const LOAD_BY_EMAIL = "SELECT `id`, `email`, 
						`registration_code`, `main`, 
						`status`, `id_user` 
						FROM `email_user` 
						WHERE `email`='<1?>';";
const LOAD_MAIN_BY_ID_USER = "SELECT `id`, `email`, 
								`registration_code`, `main`, 
								`status`, `id_user` 
								FROM `email_user` 
								WHERE `id_user`=<1?> AND `main`=1;";
const INSERT = "INSERT INTO `email_user`(`email`, `registration_code`, `main`, `status`, `id_user`) VALUES ('<1?>', '<2?>', <3?>, <4?>, <5?>);";

const UPDATE = "UPDATE `email_user` 
				SET `email` = '<2?>',
				`registration_code` = '<3?>',
				`status` = <4?>,
				`main` = <5?>,
				`id_user` = <6?> 
				WHERE `id`=<1?>;";

}
