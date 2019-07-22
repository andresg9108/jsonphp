/**/
/*INSERT privileges*/
/**/

/**/
/*Privileges Person Module*/
/**/
/*Privilege to create*/
INSERT INTO `privileges`(`id`, `status`, `id_module`) VALUES 
(1, 1, 1);
/*Title*/
INSERT INTO `title_privileges`(`title`, `id_privileges`, `id_language`) VALUES 
('Create', 1, 1),
('Crear', 1, 2);
/*Description*/
INSERT INTO `description_privileges`(`description`, `id_privileges`, `id_language`) VALUES 
('Users with this privilege will be able to create new people in the system.', 1, 1),
('Los usuarios con este privilegio podrán crear nuevas personas en el sistema.', 1, 2);
/*Privilege to update*/
INSERT INTO `privileges`(`id`, `status`, `id_module`) VALUES 
(2, 1, 1);
/*Title*/
INSERT INTO `title_privileges`(`title`, `id_privileges`, `id_language`) VALUES 
('Update', 2, 1),
('Actualizar', 2, 2);
/*Description*/
INSERT INTO `description_privileges`(`description`, `id_privileges`, `id_language`) VALUES 
('Users with this privilege can edit the data of people in the system.', 2, 1),
('Los usuarios con este privilegio pueden editar los datos de las personas en el sistema.', 2, 2);


/**/
/*Privileges User Module*/
/**/
/*Privilege to create*/
INSERT INTO `privileges`(`id`, `status`, `id_module`) VALUES 
(3, 1, 2);
/*Title*/
INSERT INTO `title_privileges`(`title`, `id_privileges`, `id_language`) VALUES 
('Create', 3, 1),
('Crear', 3, 2);
/*Description*/
INSERT INTO `description_privileges`(`description`, `id_privileges`, `id_language`) VALUES 
('Users with this privilege can breed other users.', 3, 1),
('Los usuarios con este privilegio pueden criar a otros usuarios.', 3, 2);


/**/
/*Privileges Contacts Module*/
/**/
/*Privilege to create*/
INSERT INTO `privileges`(`id`, `status`, `id_module`) VALUES 
(4, 1, 3);
/*Title*/
INSERT INTO `title_privileges`(`title`, `id_privileges`, `id_language`) VALUES 
('Create', 4, 1),
('Crear', 4, 2);
/*Description*/
INSERT INTO `description_privileges`(`description`, `id_privileges`, `id_language`) VALUES 
('Users with this privilege can create contacts in the system.', 4, 1),
('Los usuarios con este privilegio pueden crear contactos en el sistema.', 4, 2);

