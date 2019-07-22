/**/
/*INSERT department*/
/**/

/**/
/*Administration Department*/
/**/
INSERT INTO `department`(`id`) VALUES 
(1);
/*Title*/
INSERT INTO `title_department`(`title`, `id_department`, `id_language`) VALUES 
('Administration', 1, 1),
('Administración', 1, 2);
/*Description*/
INSERT INTO `description_department`(`description`, `id_department`, `id_language`) VALUES 
('In this department, the global and personal configurations of the system are managed.', 1, 1),
('En este departamento, se gestionan las configuraciones globales y personales del sistema.', 1, 2);

/**/
/*Test Department*/
/**/
INSERT INTO `department`(`id`) VALUES 
(2);
/*Title*/
INSERT INTO `title_department`(`title`, `id_department`, `id_language`) VALUES 
('Test', 2, 1),
('Prueba', 2, 2);
/*Description*/
INSERT INTO `description_department`(`description`, `id_department`, `id_language`) VALUES 
('This department includes the modules that are in the testing phase.', 2, 1),
('Este departamento incluye los módulos que están en la fase de prueba.', 2, 2);
