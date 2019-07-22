 /**/
 /*TABLE app_registration*/
 /**/
 create table app_registration(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 registration_code text,
 primary key(id)
 );
 
 /**/
 /*TABLE settings_type*/
 /**/
 create table settings_type(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 name varchar(250),
 description text,
 primary key(id)
 );
 
 /**/
 /*TABLE setings*/
 /**/
 create table setings(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 name varchar(250),
 description text,
 value text,
 id_settings_type int,
 primary key(id),
 foreign key(id_settings_type) references settings_type(id)
 );
 
 /**/
 /*TABLE language*/
 /**/
 create table language(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 name varchar(250),
 primary key(id)
 );
 
 /**/
 /*TABLE email_settings*/
 /**/
 create table email_settings(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 title varchar(80),
 description text,
 primary key(id)
 );
 CREATE INDEX title_email_settings ON email_settings(title);
 
 /**/
 /*TABLE send_email*/
 /**/
 create table send_email(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 email varchar(80),
 code varchar(100),
 subject text,
 message text,
 status int(1) DEFAULT 0,
 id_email_settings int,
 primary key(id),
 foreign key(id_email_settings) references email_settings(id)
 );
 
 /**/
 /*TABLE person*/
 /**/
 create table person(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 name varchar(250),
 last_name varchar(250),
 primary key(id)
 );
 CREATE INDEX name_person ON person(name);
 CREATE INDEX last_name_person ON person(last_name);
 
 /**/
 /*TABLE department*/
 /**/
 create table department(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 primary key(id)
 );
 create table title_department(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 title varchar(250),
 id_department int,
 id_language int,
 primary key(id),
 foreign key(id_department) references department(id),
 foreign key(id_language) references language(id)
 );
 CREATE INDEX title_title_department ON title_department(title);
 create table description_department(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 description varchar(250),
 id_department int,
 id_language int,
 primary key(id),
 foreign key(id_department) references department(id),
 foreign key(id_language) references language(id)
 );
 CREATE INDEX description_description_department ON description_department(description);
 
 /**/
 /*TABLE module*/
 /**/
 create table module(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 link text,
 primary key(id)
 );
 create table title_module(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 title varchar(250),
 id_module int,
 id_language int,
 primary key(id),
 foreign key(id_module) references module(id),
 foreign key(id_language) references language(id)
 );
 CREATE INDEX title_title_module ON title_module(title);
 create table description_module(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 description varchar(250),
 id_module int,
 id_language int,
 primary key(id),
 foreign key(id_module) references module(id),
 foreign key(id_language) references language(id)
 );
 CREATE INDEX description_description_module ON description_module(description);
 
 /**/
 /*TABLE depamodu*/
 /**/
 create table depamodu(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 id_department int,
 id_module int,
 primary key(id),
 foreign key(id_department) references department(id),
 foreign key(id_module) references module(id)
 );
 
 /**/
 /*TABLE privileges*/
 /**/
 create table privileges(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 status int(1) DEFAULT 0,
 id_module int,
 primary key(id),
 foreign key(id_module) references module(id)
 );
 create table title_privileges(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 title varchar(250),
 id_privileges int,
 id_language int,
 primary key(id),
 foreign key(id_privileges) references privileges(id),
 foreign key(id_language) references language(id)
 );
 CREATE INDEX title_title_privileges ON title_privileges(title);
 create table description_privileges(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 description varchar(250),
 id_privileges int,
 id_language int,
 primary key(id),
 foreign key(id_privileges) references privileges(id),
 foreign key(id_language) references language(id)
 );
 CREATE INDEX description_description_privileges ON description_privileges(description);
 
 /**/
 /*TABLE profile*/
 /**/
 create table profile(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 primary key(id)
 );
 create table title_profile(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 title varchar(250),
 id_profile int,
 id_language int,
 primary key(id),
 foreign key(id_profile) references profile(id),
 foreign key(id_language) references language(id)
 );
 CREATE INDEX title_title_profile ON title_profile(title);
 create table description_profile(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 description varchar(250),
 id_profile int,
 id_language int,
 primary key(id),
 foreign key(id_profile) references profile(id),
 foreign key(id_language) references language(id)
 );
 CREATE INDEX description_description_profile ON description_profile(description);
 
 /**/
 /*TABLE profdepa*/
 /**/
 create table profdepa(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 id_profile int,
 id_department int,
 primary key(id),
 foreign key(id_profile) references profile(id),
 foreign key(id_department) references department(id)
 );
 
 /**/
 /*TABLE profpriv*/
 /**/
 create table profpriv(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 id_profile int,
 id_privileges int,
 primary key(id),
 foreign key(id_profile) references profile(id),
 foreign key(id_privileges) references privileges(id)
 );
 
 /**/
 /*TABLE user*/
 /**/
 create table user(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 user varchar(250),
 password text,
 status int(1) DEFAULT 0,
 id_person int,
 id_profile int,
 id_language int,
 primary key(id),
 foreign key(id_person) references person(id),
 foreign key(id_profile) references profile(id),
 foreign key(id_language) references language(id)
 );
 CREATE INDEX user_user ON user(user);
 
 /**/
 /*TABLE email_user*/
 /**/
 create table email_user(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 email varchar(300),
 registration_code text,
 status int(1) DEFAULT 0,
 main int(1),
 id_user int,
 primary key(id),
 foreign key(id_user) references user(id)
 );
 CREATE INDEX email_email_user ON email_user(email); 
 /**/
 /*INSERT settings_type*/
 /**/
 INSERT INTO `settings_type`(`id`, `name`, `description`) VALUES 
 (1, 'General settings', 'General settings'),
 (2, 'Settings for emails', 'Settings for emails');
 
 /**/
 /*INSERT setings*/
 /**/
 INSERT INTO `setings`(`name`, `description`, `value`, `id_settings_type`) VALUES 
 ('maximum_session_time', '', '86400', 1),
 ('name', '', 'Test', 2),
 ('host', '', 'smtp.example.com', 2),
 ('port', '', '25', 2),
 ('smtp_secure', '', '', 2),
 ('username', '', 'info@example.com', 2),
 ('password', '', '123456', 2);
 
 /**/
 /*INSERT email_settings*/
 /**/
 INSERT INTO `email_settings`(`id`, `title`, `description`) VALUES 
 (1, 'Sending registration email.', 'Sending registration email.'),
 (2, 'Sending password recovery email.', 'Sending password recovery email.');
 
 /**/
 /*INSERT language*/
 /**/
 INSERT INTO `language`(`id`, `name`) VALUES 
 (1, 'English'),
 (2, 'Español');
 
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
 
 /**/
 /*INSERT user*/
 /**/
 INSERT INTO user(id, user, password, status, id_profile) VALUES 
 (1, 'root', 'e10adc3949ba59abbe56e057f20f883e', 1, 1);
 
