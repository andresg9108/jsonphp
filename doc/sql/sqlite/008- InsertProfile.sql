/**/
/*INSERT profile*/
/**/

/**/
/*Administrator Profile*/
/**/
INSERT INTO profile(id) VALUES 
(1);
/*Title*/
INSERT INTO `title_profile`(`title`, `id_profile`, `id_language`) VALUES 
('Administrator', 1, 1),
('Administrador', 1, 2);
/*Description*/
INSERT INTO `description_profile`(`description`, `id_profile`, `id_language`) VALUES 
('This profile is assigned to users with the nature of a system administrator.', 1, 1),
('Este perfil se le asigna a los usuarios con índole de administrador del sistema.', 1, 2);
INSERT INTO `profpriv`(`id_profile`, `id_privileges`) VALUES 
(1, 1),
(1, 2),
(1, 3),
(1, 4);
INSERT INTO `profdepa`(`id_profile`, `id_department`) VALUES 
(1, 1),
(1, 2);


/**/
/*Client Profile*/
/**/
INSERT INTO profile(id) VALUES
(2);
/*Title*/
INSERT INTO `title_profile`(`title`, `id_profile`, `id_language`) VALUES 
('Client', 2, 1),
('Cliente', 2, 2);
/*Description*/
INSERT INTO `description_profile`(`description`, `id_profile`, `id_language`) VALUES 
('This profile is assigned to users with a client nature.', 2, 1),
('Este perfil se le asigna a los usuarios con índole de cliente.', 2, 2);
