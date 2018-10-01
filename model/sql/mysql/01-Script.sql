create table app_registration(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
registration_code text,
primary key(id)
);

create table email_settings(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
title varchar(80),
description text,
index(title),
primary key(id)
);

create table send_email(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
email varchar(80),
code varchar(100),
subject text,
message text,
id_email_settings int,
primary key(id),
foreign key(id_email_settings) references email_settings(id)
);

create table person(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
name varchar(250),
last_name varchar(250),
index(name),
index(last_name),
primary key(id)
);

create table module(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
title varchar(250),
index(title),
primary key(id)
);

create table privileges(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
title varchar(250),
id_module int,
index(title),
primary key(id),
foreign key(id_module) references module(id)
);

create table profile(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
title varchar(250),
all_privileges int(1),
index(title),
primary key(id)
);

create table profpriv(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
id_profile int,
id_privileges int,
primary key(id),
foreign key(id_profile) references profile(id),
foreign key(id_privileges) references privileges(id)
);

create table user(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
user varchar(250),
password text,
status int(1),
id_person int,
id_profile int,
index(user),
index(user),
primary key(id),
foreign key(id_person) references person(id),
foreign key(id_profile) references profile(id)
);

create table email_user(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
email varchar(300),
registration_code text,
status int(1),
main int(1),
id_user int,
index(email),
primary key(id),
foreign key(id_user) references user(id)
);
