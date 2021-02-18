/**/
/*TABLE table_example*/
/**/
create table table_example(
id int not null auto_increment,
registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
name text,
last_name text,
primary key(id)
);