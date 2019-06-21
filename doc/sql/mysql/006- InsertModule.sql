/**/
/*INSERT module*/
/**/

/**/
/*Person Module*/
/**/
INSERT INTO `module`(`id`, `link`) VALUES 
(1, 'dashboard/person');
/*Title*/
INSERT INTO `title_module`(`title`, `id_module`, `id_language`) VALUES 
('Person', 1, 1),
('Persona', 1, 2);
/*Description*/
INSERT INTO `description_module`(`description`, `id_module`, `id_language`) VALUES 
('In this module the information of each one of the people who are in the system is administered.', 1, 1),
('En este módulo se administra la información de cada una de las personas que se encuentran en el sistema.', 1, 2);
/*Relation*/
INSERT INTO `depamodu`(`id_department`, `id_module`) VALUES 
(1, 1),
(2, 1);

/**/
/*User Module*/
/**/
INSERT INTO `module`(`id`, `link`) VALUES 
(2, 'dashboard/user');
/*Title*/
INSERT INTO `title_module`(`title`, `id_module`, `id_language`) VALUES 
('User', 2, 1),
('Usuario', 2, 2);
/*Description*/
INSERT INTO `description_module`(`description`, `id_module`, `id_language`) VALUES 
('In this module the information of each one of the users that are in the system is administered.', 2, 1),
('En este módulo se administra la información de cada uno de los usuarios que se encuentran en el sistema.', 2, 2);
/*Relation*/
INSERT INTO `depamodu`(`id_department`, `id_module`) VALUES 
(1, 2),
(2, 2);

/**/
/*Contacts Module*/
/**/
INSERT INTO `module`(`id`, `link`) VALUES 
(3, 'dashboard/contacts');
/*Title*/
INSERT INTO `title_module`(`title`, `id_module`, `id_language`) VALUES 
('Contacts', 3, 1),
('Contactos', 3, 2);
/*Description*/
INSERT INTO `description_module`(`description`, `id_module`, `id_language`) VALUES 
('In this module the information of the contacts belonging to each user is administered.', 3, 1),
('En este módulo se administra la información de los contactos que pertenecen a cada usuario.', 3, 2);
/*Relation*/
INSERT INTO `depamodu`(`id_department`, `id_module`) VALUES 
(2, 3);
