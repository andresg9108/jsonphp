use my_database;
create table app_registration(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
registration_code text,
primary key(id)
);

use my_database;
create table email(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
title varchar(80),
description text,
primary key(id)
);

use my_database;
create table send_email(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
email varchar(80),
code varchar(100),
subject text,
message text,
id_email int,
primary key(id),
foreign key(id_email) references email(id)
);

use my_database;
create table person(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
name varchar(250),
last_name varchar(250),
primary key(id)
);

use my_database;
create table profile(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
title varchar(250),
primary key(id)
);

use my_database;
create table user(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
email varchar(300),
user varchar(250),
password text,
status int(1),
registration_code text,
id_person int,
id_profile int,
index(user),
primary key(id),
foreign key(id_person) references person(id),
foreign key(id_profile) references profile(id)
);