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
