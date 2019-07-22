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