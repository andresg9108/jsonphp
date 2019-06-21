/**/
/*TABLE app_registration*/
/**/
create table app_registration(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
registration_code text,
primary key(id)
);

/**/
/*TABLE settings_type*/
/**/
create table settings_type(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
name varchar(250),
description text,
primary key(id)
);

/**/
/*TABLE setings*/
/**/
create table setings(
id int not null auto_increment,
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
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
name varchar(250),
primary key(id)
);

/**/
/*TABLE email_settings*/
/**/
create table email_settings(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
title varchar(80),
description text,
index(title),
primary key(id)
);

/**/
/*TABLE send_email*/
/**/
create table send_email(
id int not null auto_increment,
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
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
name varchar(250),
last_name varchar(250),
index(name),
index(last_name),
primary key(id)
);

/**/
/*TABLE department*/
/**/
create table department(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
primary key(id)
);
create table title_department(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
title varchar(250),
id_department int,
id_language int,
index(title),
primary key(id),
foreign key(id_department) references department(id),
foreign key(id_language) references language(id)
);
create table description_department(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
description varchar(250),
id_department int,
id_language int,
index(description),
primary key(id),
foreign key(id_department) references department(id),
foreign key(id_language) references language(id)
);

/**/
/*TABLE module*/
/**/
create table module(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
link text,
primary key(id)
);
create table title_module(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
title varchar(250),
id_module int,
id_language int,
index(title),
primary key(id),
foreign key(id_module) references module(id),
foreign key(id_language) references language(id)
);
create table description_module(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
description varchar(250),
id_module int,
id_language int,
index(description),
primary key(id),
foreign key(id_module) references module(id),
foreign key(id_language) references language(id)
);

/**/
/*TABLE depamodu*/
/**/
create table depamodu(
id int not null auto_increment,
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
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
status int(1) DEFAULT 0,
id_module int,
primary key(id),
foreign key(id_module) references module(id)
);
create table title_privileges(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
title varchar(250),
id_privileges int,
id_language int,
index(title),
primary key(id),
foreign key(id_privileges) references privileges(id),
foreign key(id_language) references language(id)
);
create table description_privileges(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
description varchar(250),
id_privileges int,
id_language int,
index(description),
primary key(id),
foreign key(id_privileges) references privileges(id),
foreign key(id_language) references language(id)
);

/**/
/*TABLE profile*/
/**/
create table profile(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
primary key(id)
);
create table title_profile(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
title varchar(250),
id_profile int,
id_language int,
index(title),
primary key(id),
foreign key(id_profile) references profile(id),
foreign key(id_language) references language(id)
);
create table description_profile(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
description varchar(250),
id_profile int,
id_language int,
index(description),
primary key(id),
foreign key(id_profile) references profile(id),
foreign key(id_language) references language(id)
);

/**/
/*TABLE profpriv*/
/**/
create table profpriv(
id int not null auto_increment,
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
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
user varchar(250),
password text,
status int(1) DEFAULT 0,
id_person int,
id_profile int,
id_language int,
index(user),
index(user),
primary key(id),
foreign key(id_person) references person(id),
foreign key(id_profile) references profile(id),
foreign key(id_language) references language(id)
);

/**/
/*TABLE email_user*/
/**/
create table email_user(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
email varchar(300),
registration_code text,
status int(1) DEFAULT 0,
main int(1),
id_user int,
index(email),
primary key(id),
foreign key(id_user) references user(id)
);
